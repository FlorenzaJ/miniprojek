<!DOCTYPE html>
<html>
    <head>
        <title>Homepage - Savings</title>
        <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>
        <nav>
            <h1>Savings Account</h1>
            <?php if(isset($_SESSION['user_id'])): ?>
            <div>
            <b>Welcome, <?php echo $_SESSION['user_name']; ?>
            <?php if($_SESSION['user_role'] === 'admin'): ?></b>
                    <a href="admin">Admin Dashboard</a>
                <?php endif; ?>
                <a href="save">Save Up</a>
                <a href="logout">Logout</a>
            </div>
        <?php else: ?>
            <div>
                <a href="login">Login</a>
                <a href="register">Register</a>
            </div>
        <?php endif; ?>
        </nav>


        <main>
        <h2>My Savings</h2>
        <div style="text-align: right; margin: 30px;">
                <?php $totalSavings = $savingsModel->getTotalSavings($_SESSION['user_id']); ?>
                <?php echo "Your Total Savings: Rp ", number_format($totalSavings, 2, ',', '.'); ?>
            </div>
            <?php $user_id = $_SESSION['user_id'];
            $savings = $savingsModel->getSavingsByUser($user_id); // Function to get savings for the user
            ?>
            
        <?php foreach($savings as $saving): ?>
            <div class="saving-card">
                <h3><?php echo $_SESSION['user_name'];  ?></h3>
                <p style="font-weight:500;">Amount: Rp<?php echo number_format($saving['amount']); ?></p>
                <p style="font-weight:500;">Message: <?php echo htmlspecialchars($saving['message']); ?></p>
                <small>Date: <?php echo $saving['created_at']; ?></small>
            </div>
        <?php endforeach; ?>

    </main>
    </body>
</html>