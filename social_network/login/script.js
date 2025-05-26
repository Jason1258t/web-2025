// auth.js
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('emailInput');
    const passwordInput = document.getElementById('passwordInput');

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Сбрасываем предыдущие ошибки
        resetErrors();
        
        // Валидация email
        const emailValid = validateEmail(emailInput.value);
        // Валидация пароля (минимум 6 символов)
        const passwordValid = passwordInput.value.length >= 6;
        
        if (!emailValid) {
            showError(emailInput, 'Некорректный формат email');
        }
        
        if (!passwordValid) {
            showError(passwordInput, 'Пароль должен содержать минимум 6 символов');
        }
        
        if (emailValid && passwordValid) {
            // Здесь будет отправка формы на сервер
            console.log('Форма валидна, отправляем данные');
            // loginForm.submit();
        }
    });
    
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function showError(input, message) {
        const field = input.closest('.auth-form__field');
        input.classList.add('auth-form__input_error');
        
        let errorElement = field.querySelector('.auth-form__error');
        if (!errorElement) {
            errorElement = document.createElement('p');
            errorElement.className = 'auth-form__error';
            field.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    function resetErrors() {
        document.querySelectorAll('.auth-form__input_error').forEach(input => {
            input.classList.remove('auth-form__input_error');
        });
        
        document.querySelectorAll('.auth-form__error').forEach(error => {
            error.style.display = 'none';
        });
    }
});