
document.addEventListener('DOMContentLoaded', function() {
  // Logout Functionality
  const logoutBtn = document.getElementById('logoutBtn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function(e) {
      e.preventDefault();
      if (confirm('Apakah Anda yakin ingin logout?')) {
        // Redirect ke halaman login setelah logout
        window.location.href = 'login.html';
      }
    });
  }

  // WhatsApp Floating Button
  const whatsappFloat = document.getElementById('whatsappFloat');
  if (whatsappFloat) {
    whatsappFloat.addEventListener('click', function() {
      const phoneNumber = '628888999';
      const message = 'Halo Dimsum Time, saya ingin bertanya tentang menu Anda.';
      const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
      window.open(whatsappUrl, '_blank');
    });
  }

  // Active Menu Highlight
  const currentPage = window.location.pathname.split('/').pop();
  const menuLinks = document.querySelectorAll('.dimsum-nav-links a');
  
  menuLinks.forEach(link => {
    const linkPage = link.getAttribute('href');
    if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.html')) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });

  // User Dropdown Close on Click Outside
  document.addEventListener('click', function(e) {
    const userProfile = document.querySelector('.dimsum-user-profile');
    const dropdownMenu = document.querySelector('.dimsum-dropdown-menu');
    
    if (userProfile && !userProfile.contains(e.target) && dropdownMenu) {
      dropdownMenu.style.opacity = '0';
      dropdownMenu.style.visibility = 'hidden';
      dropdownMenu.style.transform = 'translateY(-10px)';
    }
  });

});
