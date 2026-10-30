CLUBJOIN - MINIMAL FIXED PACKAGE

IMPORTANT
This package keeps your existing HTML, CSS, JavaScript, and PHP pages unchanged except for the two logout redirect paths, which are now relative so they work when the folder is named ClubJoin or ClubJoin_new.

INSTALL
1. Extract this folder to C:\xampp\htdocs\ClubJoin (or C:\xampp\htdocs\ClubJoin_new).
2. Open XAMPP Control Panel and start Apache.
3. Open the website through Chrome using:
   http://localhost/ClubJoin/
   or, if your folder is named ClubJoin_new:
   http://localhost/ClubJoin_new/
4. Do not double-click index.html or open the project through file:///; PHP pages must be served by Apache.

STUDENT PAGES
- Register: register.html
- Login: login.html
- Explore clubs: clubs.html
- Student dashboard: dashboard.php
- My joined clubs: myclubs.php
- Profile: profile.php

ADMIN PAGES
- Admin login: admin-login.html
- Username: admin
- Password: ClubJoin@123
- Admin dashboard: admin-dashboard.php
- Student management: admin-students.php
- Event management: admin-events.php

WHY MYCLUBS.PHP MAY DOWNLOAD
If clicking My Joined Clubs downloads myclubs.php instead of displaying it, Chrome is receiving the PHP source as a downloadable file. That usually means the page is not being handled by PHP/Apache. Make sure Apache is running and you opened the page using http://localhost/... rather than file:///... or a static preview/Live Server. Since other PHP pages work, compare the URL in the address bar and make sure it starts with http://localhost/ and uses the same project folder. If it still downloads, check XAMPP Apache PHP configuration or reinstall/repair the XAMPP PHP handler; changing the page's HTML/CSS will not fix a server-side PHP handler problem.

DATA
- Student registrations: data.json
- Club definitions: data/clubs.json
- Memberships: memberships.json
- Events: events.json
- Student passwords are stored as hashes.

BACKUP
Before replacing an existing folder, keep a copy of your current data.json and memberships.json. These files contain registrations and club memberships.
