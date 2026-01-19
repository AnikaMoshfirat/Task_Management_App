function showContent(page) {
  document.getElementById("contentFrame").src = page;
}

function logout() {
  if(confirm("Are you sure you want to logout?")) {
    window.location.href = "../../controller/logout.php";
  }
}

function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("collapsed");
}
