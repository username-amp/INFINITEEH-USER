document.addEventListener('DOMContentLoaded', function() {
    var contentSection = document.getElementById('content-section');
    contentSection.classList.add('transparent-bg');
});

document.addEventListener('DOMContentLoaded', function() {
    var contentSection = document.getElementById('content-section');
    contentSection.classList.add('transparent-bg');

    var aboutusTitle = document.querySelector('.aboutus-title');
    aboutusTitle.classList.add('show'); 
});
document.addEventListener('DOMContentLoaded', function() {
    var socialIcons = document.querySelectorAll('.social-icons img');

    socialIcons.forEach(function(icon) {
        icon.addEventListener('mouseover', function() {
            icon.style.transform = 'scale(1.2)'; 
            icon.style.transition = 'transform 0.3s ease'; 
        });

        icon.addEventListener('mouseout', function() {
            icon.style.transform = 'scale(1)'; 
        });
    });
});