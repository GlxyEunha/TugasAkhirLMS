<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-LEARNING APP</title>

  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/img/school.svg')}}">
  <style>
    /* General Styles */
    body {
      font-family: 'Montserrat', sans-serif;
      line-height: 1.6;
      background-color: #fbfcf7;
      color: #2d3748;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Header */
    .header {
      background: linear-gradient(120deg, #c3d3e6, #2987ab); /* Updated header gradient */
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-logo {
      font-size: 1.5rem;
      font-weight: bold;
      color: #2d3748;
    }

    .header-links {
      display: flex;
      gap: 20px;
      justify-content: center;
    }

    .header-links a {
      color: #ffffff;
      text-decoration: none;
      transition: color 0.3s ease;
      font-weight: bold;
      font-size: 1.1rem;
      padding: 10px 15px;
      border-radius: 5px;
      background-color: rgba(255, 255, 255, 0.2);
    }

    .header-links a:hover {
      background-color: rgba(255, 255, 255, 0.3);
    }

    /* Hero Section */
    .hero {
      background-color: #c3d3e6;
      padding: 80px 20px;
      text-align: center;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      color: #2d3748;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.2rem;
      color: #2d3748;
      margin-bottom: 40px;
    }

    .hero-button {
      background-color: #2987ab; /* Updated hero button color */
      color: #ffffff;
      font-weight: bold;
      font-size: 1.1rem;
      padding: 15px 30px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
    }

    .hero-button:hover {
      background-color: #015f76;
    }

    /* How It Works Section */
    .how-it-works {
      background-color: #fbfcf7;
      padding: 80px 20px;
      text-align: center;
    }

    .how-it-works h2 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #2d3748;
      margin-bottom: 40px;
    }

    .how-steps {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
    }

    .how-step {
      flex: 1;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      max-width: 300px;
      text-align: left;
    }

    .how-step:hover {
      transform: translateY(-10px);
    }

    .how-step h3 {
      font-size: 1.5rem;
      font-weight: bold;
      color: #2d3748;
      margin-bottom: 20px;
    }

    .how-step p {
      font-size: 1.1rem;
      color: #4a5568;
      line-height: 1.6;
    }

    /* Footer */
    .footer {
      background-color: #2987ab; /* Updated footer background color */
      padding: 20px;
      text-align: center;
      color: #ffffff;
      font-size: 1.1rem;
    }

    /* Media Queries */
    @media (max-width: 768px) {
      .header {
        flex-wrap: wrap;
      }

      .hero h1 {
        font-size: 2.5rem;
      }

      .hero p {
        font-size: 1rem;
      }

      .how-steps {
        flex-direction: column;
        gap: 20px;
      }

      .how-step {
        max-width: none;
        margin-bottom: 20px;
      }
    }

    @media (max-width: 480px) {
      .hero h1 {
        font-size: 2rem;
      }

      .hero p {
        font-size: 0.9rem;
      }

      .hero-button {
        font-size: 1rem;
        padding: 10px 20px;
      }

      .how-it-works h2 {
        font-size: 2rem;
      }

      .how-step h3 {
        font-size: 1.2rem;
      }

      .how-step p {
        font-size: 1rem;
      }

      .header-links {
        gap: 10px;
      }

      .header-links a {
        font-size: 0.9rem;
        padding: 8px 12px;
      }
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="header">
    <div class="header-logo">E-LEARNING APP</div>
    <nav class="header-links">
      <a href="/" class="header-link">Home</a>
      <a href="#how-it-works" class="header-link">Features</a>
      <a href="/login" class="header-link">Login</a>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <h1>Learning Management System</h1>
      <p>Pendidikan Digital, Masa Depan Anda!</p>
      <a href="/login" class="hero-button">Masuk!</a>
    </div>
  </section>

  <!-- How It Works Section -->
  <section id="how-it-works" class="how-it-works">
    <div class="container">
      <h2>Features</h2>
      <div class="how-steps">
        <div class="how-step">
          <img src="{{ asset('assets/img/tulis.svg')}}" alt="Ujian">
          <h3>1. Ujian</h3>
          <p>Dapat mengerjakan ujian kapanpun dan dimanapun.</p>
        </div>
        <div class="how-step">
          <img src="{{ asset('assets/img/book.jpg')}}" alt="Materi" width="80px" height="80px">
          <h3>2. Materi</h3>
          <p>Membaca materi dengan lebih fleksibel.</p>
        </div>
        <div class="how-step">
          <img src="{{ asset('assets/img/homework.png')}}" alt="Tugas Sekolah" width="80px" height="80px">
          <h3>3. Tugas sekolah</h3>
          <p>Kerjakan tugas sekolah dapat dilakukan dengan mudah.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      &copy; {{ now()->year }} SMP Negeri 13 Magelang
    </div>
  </footer>

</body>

</html>
