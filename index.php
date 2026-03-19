<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FORGE STUDIO — AI Motion Tracking</title>

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Inter:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #ff4d00; 
            --dark-bg: #0a0a0a;
            --glass: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--dark-bg);
            color: #ffffff;
            margin: 0;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Hero Section - Split Layout Design */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), 
                        url('https://images.pexels.com/photos/949126/pexels-photo-949126.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2') center/cover no-repeat;
            padding: 80px 5%;
        }

        .hero-title {
            font-family: 'Oswald', sans-serif;
            font-size: clamp(3rem, 8vw, 5.5rem);
            line-height: 1;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: var(--primary);
        }

        /* Sidebar Login Form */
        .login-sidebar {
            background: rgba(15, 15, 15, 0.85);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 400px;
            margin-left: auto;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }

        .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            font-weight: 700;
        }

        .form-control {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.1);
            border-color: var(--primary);
            box-shadow: none;
            color: white;
        }

        .btn-login {
            background: var(--primary);
            border: none;
            width: 100%;
            padding: 15px;
            font-family: 'Oswald', sans-serif;
            font-size: 1.1rem;
            text-transform: uppercase;
            color: white;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: scale(1.02);
            filter: brightness(1.1);
        }

        /* Capabilities Section */
        .capabilities-section {
            padding: 100px 5%;
            background: #0f0f0f;
        }

        .section-header {
            font-family: 'Oswald', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 50px;
            text-align: center;
        }

        .capability-card {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: 0.4s;
            height: 100%;
        }

        .capability-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            filter: grayscale(30%);
            transition: 0.5s;
        }

        .capability-card:hover .capability-img {
            filter: grayscale(0%);
            transform: scale(1.05);
        }

        .capability-body {
            padding: 25px;
        }

        /* Review Section */
        .review-section {
            padding: 100px 5%;
            background: var(--dark-bg);
        }

        .review-card {
            background: var(--glass);
            border: 1px solid var(--border);
            padding: 30px;
            border-radius: 20px;
            height: 100%;
        }

        .quote-icon {
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 15px;
            display: block;
        }

        footer {
            padding: 40px;
            text-align: center;
            border-top: 1px solid var(--border);
            font-size: 0.8rem;
            color: #555;
        }

        @media (max-width: 992px) {
            .hero-section { flex-direction: column; text-align: center; }
            .login-sidebar { margin: 40px auto 0; }
        }
    </style>
</head>
<body>

<section class="hero-section">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title">FORGE<br><span>YOUR LIMITS.</span></h1>
                <p class="lead text-white-50" style="max-width: 600px;">Experience the next generation of training. Our AI-driven engine tracks every movement, counts your reps, and perfects your form in real-time.</p>
                <div class="mt-4 d-none d-lg-block">
                    <span class="badge rounded-pill bg-dark border border-secondary p-2 px-3">COMPUTER VISION</span>
                    <span class="badge rounded-pill bg-dark border border-secondary p-2 px-3 ms-2">REP TRACKER</span>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="login-sidebar">
                    <h3 class="font-oswald mb-4">ATHLETE LOGIN</h3>
                    <form action="login_log.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Athlete ID</label>
                            <input type="text" name="username" class="form-control" placeholder="MEMBER_001" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Access Token</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn-login">Open Dashboard</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="capabilities-section">
    <div class="container">
        <h2 class="section-header">SYSTEM CAPABILITIES</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="capability-card">
                    <img src="https://images.pexels.com/photos/414029/pexels-photo-414029.jpeg?auto=compress&cs=tinysrgb&w=800" class="capability-img" alt="Rep Counter">
                    <div class="capability-body">
                        <h4 class="font-oswald text-primary">REAL-TIME REP COUNTER</h4>
                        <p class="small text-muted">Automatically detects and logs repetitions for 40+ exercises using advanced motion tracking.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="capability-card">
                    <img src="https://images.pexels.com/photos/703014/pexels-photo-703014.jpeg?auto=compress&cs=tinysrgb&w=800" class="capability-img" alt="Form Check">
                    <div class="capability-body">
                        <h4 class="font-oswald text-primary">AI FORM ANALYSIS</h4>
                        <p class="small text-muted">Skeleton mapping analyzes your posture to ensure maximum efficiency and injury prevention.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="capability-card">
                    <img src="https://images.pexels.com/photos/3757954/pexels-photo-3757954.jpeg?auto=compress&cs=tinysrgb&w=800" class="capability-img" alt="Live Telemetry">
                    <div class="capability-body">
                        <h4 class="font-oswald text-primary">LIVE TELEMETRY HUD</h4>
                        <p class="small text-muted">Visualize your velocity, power output, and time-under-tension via a high-tech interface.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="review-section">
    <div class="container">
        <h2 class="section-header">ATHLETE REVIEWS</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="review-card">
                    <span class="quote-icon">"</span>
                    <p class="small text-white-50">"The rep counting is pinpoint accurate. It keeps me focused on the intensity rather than the numbers."</p>
                    <h6 class="text-primary mt-3 font-oswald">— DAVID H.</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="review-card">
                    <span class="quote-icon">"</span>
                    <p class="small text-white-50">"Forge Studio is the only app I've used that actually understands my squat depth. Truly impressive tech."</p>
                    <h6 class="text-primary mt-3 font-oswald">— SARAH L.</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="review-card">
                    <span class="quote-icon">"</span>
                    <p class="small text-white-50">"The UI is clean and professional. It feels like a high-end tool for serious athletes."</p>
                    <h6 class="text-primary mt-3 font-oswald">— MICHAEL K.</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2026 FORGE STUDIO — AI FITNESS ENGINE | POWERED BY COMPUTER VISION</p>
</footer>

</body>
</html>