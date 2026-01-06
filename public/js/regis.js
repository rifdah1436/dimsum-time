
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                confirmPasswordInput.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });

            // Password strength indicator
            const strengthMeter = document.getElementById('strengthMeter');

            passwordInput.addEventListener('input', function () {
                const password = this.value;
                let strength = 0;

                // Length check
                if (password.length >= 8) strength += 1;
                if (password.length >= 12) strength += 1;

                // Contains numbers
                if (/\d/.test(password)) strength += 1;

                // Contains uppercase
                if (/[A-Z]/.test(password)) strength += 1;

                // Contains special characters
                if (/[^A-Za-z0-9]/.test(password)) strength += 1;

                // Update strength meter
                if (strength === 0) {
                    strengthMeter.className = 'strength-meter';
                } else if (strength <= 2) {
                    strengthMeter.className = 'strength-meter weak';
                } else if (strength === 3) {
                    strengthMeter.className = 'strength-meter fair';
                } else if (strength === 4) {
                    strengthMeter.className = 'strength-meter good';
                } else {
                    strengthMeter.className = 'strength-meter strong';
                }
            });

            // Form validation
            const registrationForm = document.getElementById('registrationForm');

            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            function validatePhone(phone) {
                const re = /^[0-9]{10,13}$/;
                return re.test(phone.replace(/[^0-9]/g, ''));
            }

            function validatePassword(password) {
                return password.length >= 8 && /\d/.test(password) && /[a-zA-Z]/.test(password);
            }

            registrationForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Get form values
                const name = document.getElementById('name').value.trim();
                const phone = document.getElementById('phone').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const terms = document.getElementById('terms').checked;

                // Reset errors
                const allGroups = ['nameGroup', 'phoneGroup', 'emailGroup', 'passwordGroup', 'confirmPasswordGroup'];
                allGroups.forEach(group => {
                    document.getElementById(group).classList.remove('error');
                });
                document.getElementById('termsError').style.display = 'none';

                let isValid = true;

                // Validate name
                if (name.length < 3) {
                    document.getElementById('nameGroup').classList.add('error');
                    isValid = false;
                }

                // Validate phone
                if (!validatePhone(phone)) {
                    document.getElementById('phoneGroup').classList.add('error');
                    isValid = false;
                }

                // Validate email
                if (!validateEmail(email)) {
                    document.getElementById('emailGroup').classList.add('error');
                    isValid = false;
                }

                // Validate password
                if (!validatePassword(password)) {
                    document.getElementById('passwordGroup').classList.add('error');
                    isValid = false;
                }

                // Validate confirm password
                if (password !== confirmPassword) {
                    document.getElementById('confirmPasswordGroup').classList.add('error');
                    isValid = false;
                }

                // Validate terms
                if (!terms) {
                    document.getElementById('termsError').style.display = 'block';
                    isValid = false;
                }

                if (isValid) {
                    const submitBtn = registrationForm.querySelector('.submit-button');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;

                    // Simulate API call
                    setTimeout(() => {
                        submitBtn.classList.remove('loading');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;

                        alert('Pendaftaran berhasil! Silakan cek email untuk verifikasi akun.');
                        registrationForm.reset();
                        strengthMeter.className = 'strength-meter';
                    }, 1500);
                }
            });

            // Real-time validation
            document.getElementById('name').addEventListener('blur', function () {
                if (this.value.trim().length < 3) {
                    document.getElementById('nameGroup').classList.add('error');
                } else {
                    document.getElementById('nameGroup').classList.remove('error');
                }
            });

            document.getElementById('phone').addEventListener('blur', function () {
                if (!validatePhone(this.value)) {
                    document.getElementById('phoneGroup').classList.add('error');
                } else {
                    document.getElementById('phoneGroup').classList.remove('error');
                }
            });

            document.getElementById('email').addEventListener('blur', function () {
                if (!validateEmail(this.value)) {
                    document.getElementById('emailGroup').classList.add('error');
                } else {
                    document.getElementById('emailGroup').classList.remove('error');
                }
            });

            document.getElementById('confirmPassword').addEventListener('blur', function () {
                const password = document.getElementById('password').value;
                if (this.value !== password) {
                    document.getElementById('confirmPasswordGroup').classList.add('error');
                } else {
                    document.getElementById('confirmPasswordGroup').classList.remove('error');
                }
            });

            // Terms and privacy links
            document.querySelectorAll('.terms-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    alert('Halaman syarat & ketentuan akan dibuka di tab baru.');
                });
            });

            // Login link
            document.querySelector('.login-link').addEventListener('click', function (e) {
                e.preventDefault();
                window.location.href = 'login.html'; // Langsung redirect ke login
            });

            // Format phone number
            document.getElementById('phone').addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = value.substring(0, 13);
                    if (value.length > 4) {
                        value = value.replace(/(\d{4})(\d{4})/, '$1-$2');
                    }
                    if (value.length > 9) {
                        value = value.replace(/(\d{4})-(\d{4})(\d{1,4})/, '$1-$2-$3');
                    }
                }
                e.target.value = value;
            });
        });