console.log('HomePage loaded successfully.');

const lTitle = document.getElementById('title');
if (lTitle) {
    lTitle.textContent = 'Welcome to the Task Management System!';
}

const aboutUsLink = document.getElementById('aboutUs');
if (aboutUsLink) {
    aboutUsLink.addEventListener('click', function(event) {
        event.preventDefault();

        const infoSection = document.querySelector('#loadMc');  
        if (infoSection) {
            infoSection.innerHTML = `
                <h3 style="color: rgb(41, 15, 15);">About Our Platform</h3>
                <p style="color: rgb(0,0,0);"><i>
                    Our <strong>Task Management System</strong> helps individuals and teams organize, track and 
                    complete tasks seamlessly. 
                    With a user-friendly workspace, 
                    it boosts productivity, manages workloads 
                    and keeps users focused. 
                    Whether managing personal tasks or collaborating,
                    the platform ensures secure access, flexible organization and 
                    clear progress tracking.
                </i></p>
            `;
        }
    });
}
