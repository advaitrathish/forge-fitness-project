from flask import Flask, render_template, Response, jsonify
import cv2
import mediapipe as mp
import numpy as np
import time
from datetime import datetime
from collections import deque
import mysql.connector

app = Flask(__name__)

# --- Configuration ---
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '', 
    'database': 'gym'
}

# Mapping exercise names to IDs (ex_id)
EXERCISE_MAP = {
    "pushups": 1, "squats": 2, "curls": 3, "pullups": 4, 
    "tricepdips": 5, "lunges": 6, "lateral": 7, "crunches": 8, "planks": 9
}

# --- Database Helper ---
def save_to_db(exercise_name, count):
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        
        now = datetime.now()
        log_date = now.strftime('%Y-%m-%d')
        log_time = now.strftime('%H:%M:%S')
        mem_name = "Guest_User" # You can replace this with session['user'] later
        
        query = """INSERT INTO gym_logsa 
                   (mem_name, exercise_name, exercise_count, log_date, log_time) 
                   VALUES (%s, %s, %s, %s, %s)"""
        
        values = (mem_name, exercise_name, count, log_date, log_time)
        
        cursor.execute(query, values)
        conn.commit()
        cursor.close()
        conn.close()
    except Exception as e:
        print(f"Database Error: {e}")

# --- MediaPipe Setup ---
mp_pose = mp.solutions.pose
mp_draw = mp.solutions.drawing_utils
pose = mp_pose.Pose(min_detection_confidence=0.7, min_tracking_confidence=0.7)

# --- Global State ---
class WorkoutState:
    def __init__(self):
        self.count = 0
        self.stage = "down"
        self.active_exercise = "lunges"
        self.start_time = 0
        self.angle_buffer = deque(maxlen=5)
        self.up_frames = 0
        self.down_frames = 0

state = WorkoutState()

def calculate_angle(a, b, c):
    a, b, c = np.array(a), np.array(b), np.array(c)
    radians = np.arctan2(c[1]-b[1], c[0]-b[0]) - np.arctan2(a[1]-b[1], a[0]-b[0])
    angle = np.abs(radians*180.0/np.pi)
    return angle if angle <= 180.0 else 360-angle

def run_logic(lm, ex):
    """Core Logic with Updated Database Fields"""
    def get_pt(id): return [lm[id].x, lm[id].y]
    
    # Generic Landmark Prep
    s, e, w = get_pt(11), get_pt(13), get_pt(15) 
    h, k, a = get_pt(23), get_pt(25), get_pt(27) 

    if ex == "pushups":
        l_vis, r_vis = lm[13].visibility, lm[14].visibility
        if l_vis > r_vis:
            s, e, w, h, a, vis = get_pt(11), get_pt(13), get_pt(15), get_pt(23), get_pt(27), l_vis
        else:
            s, e, w, h, a, vis = get_pt(12), get_pt(14), get_pt(16), get_pt(24), get_pt(28), r_vis

        if vis < 0.8: return 
        v1, v2 = np.array([s[0]-e[0], s[1]-e[1]]), np.array([w[0]-e[0], w[1]-e[1]])
        angle = np.degrees(np.arccos(np.clip(np.dot(v1/np.linalg.norm(v1), v2/np.linalg.norm(v2)), -1.0, 1.0)))
        
        if angle > 160 and abs(s[1] - h[1]) < 0.25 and 165 < calculate_angle(s, h, a) < 195:
            state.stage = "up"
        if state.stage == "up" and angle < 90:
            state.stage = "down"
            state.count += 1
            save_to_db(ex, state.count)

    elif ex == "squats":
        l_vis, r_vis = lm[25].visibility, lm[26].visibility
        side_h, side_k, side_a = (get_pt(23), get_pt(25), get_pt(27)) if l_vis > r_vis else (get_pt(24), get_pt(26), get_pt(28))
        angle = calculate_angle(side_h, side_k, side_a)

        if angle > 155: state.stage = "up"
        if state.stage == "up" and angle < 115:
            if side_h[1] > (side_k[1] * 0.85): 
                state.stage = "down"
                state.count += 1
                save_to_db(ex, state.count)

    elif ex == "curls":
        l_vis, r_vis = lm[13].visibility, lm[14].visibility
        s, e, w = (get_pt(11), get_pt(13), get_pt(15)) if l_vis > r_vis else (get_pt(12), get_pt(14), get_pt(16))
        v1, v2 = np.array([s[0]-e[0], s[1]-e[1]]), np.array([w[0]-e[0], w[1]-e[1]])
        angle = np.degrees(np.arccos(np.clip(np.dot(v1/np.linalg.norm(v1), v2/np.linalg.norm(v2)), -1.0, 1.0)))
        
        if angle > 160: state.stage = "down"
        if state.stage == "down" and angle < 35 and w[1] < e[1]:
            state.stage = "up"
            state.count += 1
            save_to_db(ex, state.count)

    elif ex == "pullups":
        l_vis, r_vis = lm[13].visibility, lm[14].visibility
        s, e, w, vis = (get_pt(11), get_pt(13), get_pt(15), l_vis) if l_vis > r_vis else (get_pt(12), get_pt(14), get_pt(16), r_vis)
        if vis > 0.65:
            state.angle_buffer.append(calculate_angle(s, e, w))
            curr_angle = sum(state.angle_buffer) / len(state.angle_buffer)
            is_hanging = (lm[15].y < lm[11].y) and (lm[16].y < lm[12].y)
            if curr_angle > 160 and is_hanging: state.stage = "down"
            elif curr_angle < 75 and state.stage == "down" and lm[0].y < (lm[15].y + lm[16].y)/2:
                state.stage = "up"
                state.count += 1
                save_to_db(ex, state.count)

    elif ex == "planks":
        vis = max(lm[23].visibility, lm[24].visibility)
        if vis > 0.5:
            s, h, a = (get_pt(11), get_pt(23), get_pt(27)) if lm[23].visibility > lm[24].visibility else (get_pt(12), get_pt(24), get_pt(28))
            angle = calculate_angle(s, h, a)
            if 160 < angle < 200 and abs(s[1] - a[1]) < 0.15:
                if state.stage != "active":
                    state.start_time = time.time() - state.count 
                    state.stage = "active"
                new_sec = int(time.time() - state.start_time)
                if new_sec != state.count:
                    state.count = new_sec
                    save_to_db(ex, state.count)
            else: state.stage = "paused"

    # Note: Add same save_to_db(ex, state.count) for lunges, lateral, crunches, tricepdips as needed.

def generate_frames():
    cap = cv2.VideoCapture(0)
    while True:
        success, frame = cap.read()
        if not success: break
        frame = cv2.flip(frame, 1)
        rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        results = pose.process(rgb)
        if results.pose_landmarks:
            run_logic(results.pose_landmarks.landmark, state.active_exercise)
            mp_draw.draw_landmarks(frame, results.pose_landmarks, mp_pose.POSE_CONNECTIONS)
        
        cv2.rectangle(frame, (0,0), (300, 80), (20,20,20), -1)
        label = "SEC" if state.active_exercise == "planks" else "REPS"
        cv2.putText(frame, f"{state.active_exercise.upper()}", (10, 30), 2, 0.7, (0, 255, 136), 2)
        cv2.putText(frame, f"{label}: {state.count}", (10, 65), 2, 1, (255, 255, 255), 2)
        ret, buffer = cv2.imencode('.jpg', frame)
        yield (b'--frame\r\n' b'Content-Type: image/jpeg\r\n\r\n' + buffer.tobytes() + b'\r\n')

@app.route('/')
def index():
    exercises = list(EXERCISE_MAP.keys())
    return render_template('index.html', exercises=exercises)

@app.route('/workout/<type>')
def workout(type):
    state.active_exercise = type
    state.count = 0
    state.start_time = time.time()
    return render_template('exercise.html', exercise=type)

@app.route('/video_feed')
def video_feed():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/start')
def start_session():
    state.count = 0
    state.stage = "down" if state.active_exercise != "planks" else "paused"
    state.start_time = time.time()
    return jsonify({"status": "started"})

@app.route('/data')
def get_data():
    elapsed = int(time.time() - state.start_time) if state.start_time else 0
    
    # Simulate history - in production, fetch from database
    history = [
        {"time": "12:30:15", "count": state.count, "grade": "A+"},
        {"time": "12:30:16", "count": state.count, "grade": "A+"}
    ]
    
    return jsonify({
        "time": elapsed,
        "count": state.count,
        "complete": elapsed > 300,
        "history": history
    })

if __name__ == "__main__":
    app.run(debug=True)