<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 6px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h2 style="color: #333;">Halo, {{ $user->name }} 👋</h2>
        <p>Selamat datang di platform kami! Kami sangat senang kamu telah bergabung.</p>

        <p>Dengan akun kamu, kamu bisa:</p>
        <ul>
            <li>Akses berbagai kursus menarik</li>
            <li>Belajar dari instruktur berpengalaman</li>
            <li>Lacak progres pembelajaran kamu</li>
        </ul>

        <p>Kalau ada pertanyaan atau butuh bantuan, jangan ragu untuk menghubungi kami.</p>

        <p>Salam hangat,<br>
            Tim Kami</p>
    </div>
</body>

</html>
