<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', () => handleAction(button.id));
    });

    const myButton = document.getElementById('myBtn');
    window.onscroll = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            myButton.style.display = 'block';
        } else {
            myButton.style.display = 'none';
        }
    };

    myButton.addEventListener('click', () => {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
});

async function handleAction(action) {
    const output = document.getElementById('vendorOutput');
    output.innerHTML = '<p>Loading...</p>';
    try {
        const response = await fetch('forum_gen.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=${action}`
        });
        const result = await response.text();
        output.innerHTML = result;
    } catch (error) {
        output.innerHTML = 'Error loading data.';
        console.error('Error:', error);
    }
}
</script>