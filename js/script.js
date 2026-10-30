function validateRegistration() {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const mobile = document.getElementById("mobile").value.trim();
    const password = document.getElementById("password").value;
    const course = document.getElementById("course").value;
    const year = document.getElementById("year").value;
    const terms = document.getElementById("terms").checked;
    if (!/^[a-zA-Z .'-]{2,80}$/.test(name)) { alert("Please enter a valid name."); return false; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert("Please enter a valid email."); return false; }
    if (!/^[0-9]{10}$/.test(mobile)) { alert("Mobile number must contain exactly 10 digits."); return false; }
    if (password.length < 8) { alert("Password must contain at least 8 characters."); return false; }
    if (!course || !year) { alert("Please select your course and year."); return false; }
    if (!terms) { alert("Please accept the terms and conditions."); return false; }
    return true;
}
const clubList = document.getElementById("clubList");
if (clubList) {
 const searchInput = document.getElementById("searchClub");
 const categoryFilter = document.getElementById("categoryFilter");
 const loading = document.getElementById("loadingMessage");
 const noResults = document.getElementById("noResults");
 const errorMessage = document.getElementById("errorMessage");
 let allClubs = [];
 const params = new URLSearchParams(window.location.search);
 if (params.get("status") === "success") alert("You have successfully joined the club!");
 if (params.get("status") === "already_joined") alert("You have already joined this club.");
 fetch("data/clubs.json").then(r => { if (!r.ok) throw new Error("Unable to load clubs."); return r.json(); }).then(clubs => {
  allClubs = clubs;
  if (loading) loading.hidden = true;
  displayClubs();
 }).catch(err => { console.error(err); if (loading) loading.hidden = true; if (errorMessage) { errorMessage.textContent = "Unable to load clubs. Please check data/clubs.json."; errorMessage.hidden = false; } });
 function displayClubs() {
  const term = searchInput ? searchInput.value.toLowerCase().trim() : "";
  const category = categoryFilter ? categoryFilter.value : "";
  const filtered = allClubs.filter(c => ((c.name || "").toLowerCase().includes(term) || (c.description || "").toLowerCase().includes(term)) && (!category || c.category === category)).sort((a,b) => (a.name || "").localeCompare(b.name || ""));
  clubList.innerHTML = "";
  if (noResults) noResults.hidden = filtered.length !== 0;
  filtered.forEach(club => {
   const article = document.createElement("article"); article.className = "club-card";
   const h = document.createElement("h3"); h.textContent = club.name || "Club";
   const p = document.createElement("p"); p.textContent = club.description || "";
   const c = document.createElement("p"); c.className = "category-pill"; c.textContent = club.category || "Other";
   const form = document.createElement("form"); form.action = "join.php"; form.method = "post";
   const input = document.createElement("input"); input.type = "hidden"; input.name = "club_name"; input.value = club.name || "";
   const button = document.createElement("button"); button.type = "submit"; button.textContent = "Join Club";
   form.append(input, button); article.append(h,p,c,form); clubList.appendChild(article);
  });
 }
 if (searchInput) searchInput.addEventListener("input", displayClubs);
 if (categoryFilter) categoryFilter.addEventListener("change", displayClubs);
}// Shared responsive navigation and active-page state.
document.addEventListener("DOMContentLoaded", () => {
    const standardLinks = [["Home", "index.html"], ["About", "about.html"], ["Clubs", "clubs.html"], ["Register", "register.html"], ["Student Login", "login.html"], ["Admin", "admin-login.html"], ["Contact", "contact.html"]];
    let nav = document.querySelector("body > nav");
    if (!nav) {
        nav = document.createElement("nav");
        nav.setAttribute("aria-label", "Main navigation");
        const header = document.querySelector("body > header");
        if (header) header.insertAdjacentElement("afterend", nav);
        else document.body.prepend(nav);
    }
    const canonical = new Set(standardLinks.map(([, href]) => href));
    const extras = Array.from(nav.querySelectorAll("a"))
        .filter(link => !canonical.has(link.getAttribute("href")))
        .map(link => [link.textContent.trim(), link.getAttribute("href")]);
    nav.replaceChildren();
    const brand = document.createElement("a");
    brand.className = "nav-brand";
    brand.href = "index.html";
    brand.innerHTML = '<span class="brand-mark" aria-hidden="true">C</span><span>ClubJoin</span>';
    nav.append(brand);
    const toggle = document.createElement("button");
    toggle.className = "nav-toggle";
    toggle.type = "button";
    toggle.setAttribute("aria-expanded", "false");
    toggle.setAttribute("aria-label", "Open navigation menu");
    toggle.innerHTML = '<span aria-hidden="true">☰</span><span>Menu</span>';
    nav.append(toggle);
    const links = document.createElement("div");
    links.className = "nav-links";
    const current = window.location.pathname.split("/").pop() || "index.html";
    [...standardLinks, ...extras].forEach(([label, href]) => {
        if (!href || Array.from(links.querySelectorAll("a")).some(link => link.getAttribute("href") === href)) return;
        const link = document.createElement("a");
        link.href = href;
        link.textContent = label;
        if (href === current) link.setAttribute("aria-current", "page");
        if (href === "register.html") link.classList.add("nav-cta");
        links.append(link);
    });
    nav.append(links);
    toggle.addEventListener("click", () => {
        const open = toggle.getAttribute("aria-expanded") === "true";
        toggle.setAttribute("aria-expanded", String(!open));
        toggle.setAttribute("aria-label", open ? "Open navigation menu" : "Close navigation menu");
        nav.classList.toggle("nav-open", !open);
    });
    links.addEventListener("click", event => {
        if (event.target.closest("a")) {
            nav.classList.remove("nav-open");
            toggle.setAttribute("aria-expanded", "false");
            toggle.setAttribute("aria-label", "Open navigation menu");
        }
    });
    document.addEventListener("keydown", event => {
        if (event.key === "Escape") {
            nav.classList.remove("nav-open");
            toggle.setAttribute("aria-expanded", "false");
            toggle.setAttribute("aria-label", "Open navigation menu");
        }
    });
});

