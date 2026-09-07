<?php $isAuthenticated = $isAuthenticated ?? false; ?>
</main>
<footer class="site-footer">
	<div class="site-footer-inner">
		<div class="footer-intro">
			<a class="footer-brand" href="index.php"><span class="footer-brand-icon"><i class="fa-solid fa-chart-line"></i></span><span>MoneyMap <small>v2.0</small></span></a>
			<p>A calmer, clearer way to understand your money and plan what comes next.</p>
		</div>
		<?php if ($isAuthenticated): ?>
		<div class="footer-column"><span class="footer-label">Your workspace</span><a href="dashboard.php">Dashboard</a><a href="transactions.php">Transactions</a><a href="archive.php">Yearly archive</a></div>
		<div class="footer-column"><span class="footer-label">Account</span><a href="profile.php">Profile</a><a data-confirm="Are you sure you want to log out?" href="logout.php">Log out</a></div>
		<?php else: ?>
		<div class="footer-column"><span class="footer-label">Explore</span><a href="index.php#features">How it works</a><a href="login.php">Sign in</a><a href="register.php">Create account</a></div>
		<div class="footer-column"><span class="footer-label">Get started</span><p>Track your first transaction and build a clearer financial picture.</p><a class="footer-action-link" href="register.php">Open MoneyMap <i class="fa-solid fa-arrow-right"></i></a></div>
		<?php endif; ?>
		<div class="footer-status"><span class="footer-status-dot"></span><strong>MoneyMap is ready</strong><p>Your financial workspace is available whenever you are.</p></div>
	</div>
	<div class="site-footer-bottom"><span>MoneyMap v2.0 <b>•</b> Personal finance, made clear.</span><span>Developed by <strong><a href="https://github.com/Farhan-Islam-Rafid" target="_blank" rel="noopener noreferrer">Farhan Islam Rafid</a></strong>.</span></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
