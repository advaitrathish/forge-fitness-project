<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_USER_ID'];
    
    // Fetch trainee data
    $result = $db->prepare("SELECT * FROM members WHERE Log_Id = '$Log_Id'");
    $result->execute();
    
    for($i=0; $row = $result->fetch(); $i++)
    {       
        $user_name = $row["tname"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <style>
        .chat-container { height: 300px; overflow-y: auto; border: 1px solid #e0e0e0; padding: 20px; background: #ffffff; border-radius: 12px; margin-bottom: 20px; }
        .bot-msg { background: #f0f2f5; color: #1c1e21; padding: 12px 16px; border-radius: 18px 18px 18px 4px; margin-bottom: 15px; max-width: 85%; border: 1px solid #ddd; }
        .user-msg { background: #3f51b5; color: white; padding: 12px 16px; border-radius: 18px 18px 4px 18px; margin-bottom: 15px; max-width: 85%; margin-left: auto; text-align: right; }
        .ai-chip { cursor: pointer; display: inline-block; padding: 6px 14px; background: #f1f3f4; border: 1px solid #3f51b5; border-radius: 20px; margin: 4px; font-size: 13px; color: #3f51b5; font-weight: 600; }
        .typing { font-style: italic; color: #999; font-size: 12px; margin-bottom: 10px; display: none; }
        #videoBox { min-height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9ff; border: 2px dashed #3f51b5; border-radius: 12px; }
    </style>
</head>
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
    <div class="page-wrapper">
        <?php include("include/header.php"); ?>
        <div class="page-container">
            <?php include("include/leftmenu.php"); ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class="pull-left"><div class="page-title">GymBot AI v2.0</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="card card-box">
                                <div class="card-head"><header>Coach <?php echo $user_name; ?>'s Assistant</header></div>
                                <div class="card-body">
                                    <div class="chat-container" id="chatBox">
                                        <div class="bot-msg">Hi <strong><?php echo $user_name; ?></strong>! I'm ready. Ask me about reps, diet, recovery, or specific exercises!</div>
                                    </div>
                                    <div id="typingIndicator" class="typing">GymBot is thinking...</div>
                                    
                                    <div class="input-group">
                                        <input type="text" id="userInput" class="form-control" placeholder="Ask me anything..." onkeypress="handleKeyPress(event)">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" onclick="sendMessage()"><i class="fa fa-paper-plane"></i></button>
                                        </span>
                                    </div>

                                    <div style="margin-top:15px;">
                                        <div class="ai-chip" onclick="quickAsk('What should I eat?')">🍎 Diet Advice</div>
                                        <div class="ai-chip" onclick="quickAsk('How much rest do I need?')">😴 Recovery</div>
                                        <div class="ai-chip" onclick="quickAsk('Cardio or Weights?')">🏃 Cardio vs Weights</div>
                                        <div class="ai-chip" onclick="quickAsk('Pushups 50 reps')">💪 High Volume Check</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <div class="card card-box">
                                <div class="card-head"><header>Video Demo</header></div>
                                <div class="card-body" id="videoBox">
                                    <div class="text-center text-muted">
                                        <i class="fa fa-play-circle fa-3x"></i><br>Video links will appear here.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("include/js.php"); ?>
    
    <script>
        function handleKeyPress(e) { if (e.keyCode === 13) { sendMessage(); } }

        function sendMessage() {
            let inputField = document.getElementById('userInput');
            let input = inputField.value.trim();
            if(!input) return;
            
            appendMessage(input, 'user-msg');
            inputField.value = '';
            
            document.getElementById('typingIndicator').style.display = 'block';

            setTimeout(() => {
                document.getElementById('typingIndicator').style.display = 'none';
                let ai = analyzeInput(input);
                appendMessage(ai.msg, 'bot-msg');
                if(ai.exercise) updateVideoBox(ai.exercise);
            }, 800);
        }

        function analyzeInput(str) {
            let text = str.toLowerCase();
            let repsMatch = text.match(/\d+/);
            let res = { msg: "", exercise: null };

            // 1. REP COUNT LOGIC
            if(repsMatch) {
                let count = parseInt(repsMatch[0]);
                if(count < 6) res.msg = "That's <strong>Power Training</strong>. High weight, low reps builds massive strength. Ensure 3-5 min rest!";
                else if(count <= 12) res.msg = "You're in the <strong>Hypertrophy Zone</strong>. This is the best range for muscle growth (bodybuilding).";
                else res.msg = "That's <strong>Endurance Training</strong>. High reps improve muscle stamina and burn more calories.";
                res.exercise = text.replace(/\d+/g, '').replace('reps', '').trim();
            } 
            // 2. DIET & NUTRITION
            else if(text.includes("eat") || text.includes("diet") || text.includes("protein")) {
                res.msg = "Nutrition is 70% of the game! Aim for 1.6g of protein per kg of bodyweight and stay hydrated. 🥩🥦";
            }
            // 3. RECOVERY & SLEEP
            else if(text.includes("rest") || text.includes("sleep") || text.includes("sore")) {
                res.msg = "Muscles grow while you sleep, not while you lift! Aim for 7-9 hours and don't train the same muscle 2 days in a row.";
            }
            // 4. CARDIO VS WEIGHTS
            else if(text.includes("cardio") || text.includes("weight")) {
                res.msg = "Weights build the engine (muscle), and cardio tunes it. Do weights first for energy, then cardio to burn fat!";
            }
            // 5. GREETINGS
            else if(text.includes("hello") || text.includes("hi")) {
                res.msg = "Hello! I'm your GymBot. Try typing an exercise name or asking for diet tips!";
            }
            // 6. DEFAULT EXERCISE CHECK
            else {
                res.msg = `I've noted <strong>"${str}"</strong>. Check the right panel for a form guide! For better advice, tell me your rep count.`;
                res.exercise = str;
            }
            return res;
        }

        function appendMessage(text, className) {
            let chatBox = document.getElementById('chatBox');
            let div = document.createElement('div');
            div.className = className;
            div.innerHTML = text;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function updateVideoBox(ex) {
            let query = encodeURIComponent(ex + " workout form");
            document.getElementById('videoBox').innerHTML = `
                <div style="width:100%">
                    <h4 class="text-primary">Demo: ${ex}</h4>
                    <a href="https://www.youtube.com/results?search_query=${query}" target="_blank" class="btn btn-danger btn-block">
                        <i class="fa fa-youtube-play"></i> Watch on YouTube
                    </a>
                </div>`;
        }

        function quickAsk(text) {
            document.getElementById('userInput').value = text;
            sendMessage();
        }
    </script>
</body>
</html>