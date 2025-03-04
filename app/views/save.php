<!DOCTYPE html>
<html>
<head>
    <title>Savings Account</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav>
        <h1>Savings Account</h1>
        <a href="home">Home</a>
    </nav>

    <main>
        <h2>Add to Savings</h2>
        <form method="POST" action="save">
            <div>
                <label>Amount (Rp)</label>
                <input type="number" name="amount" required>
            </div>
            <div>
                <label>Message</label>
                <textarea name="message" required></textarea>
            </div>
            <button type="submit">Save Up</button>
        </form>
    </main>
</body>
</html>