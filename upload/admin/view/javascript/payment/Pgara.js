document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('test-settings').addEventListener('click', function () {
        const merchantId = document.getElementById('input-merchant-id').value;
        const username = document.getElementById('input-username').value;
        const password = document.getElementById('input-password').value;

        if (merchantId && username && password) {
            fetch('index.php?route=extension/payment/Pgara/testSettings&user_token=' + user_token, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ merchantId, username, password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Access Token: ' + data.access_token);
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert('Please fill in all fields.');
        }
    });
});
