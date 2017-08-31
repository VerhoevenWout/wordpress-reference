Hi developers, had some troubles today exporting/importing a database. At the end I found the solution which might be worth sharing.
The error I got during importing was:
Unknown collation: ‘utf8mb4_unicode_520_ci’

This solution worked for me
1) Click the “Export” tab for the database
2) Click the “Custom” radio button
3) Go the section titled “Format-specific options” and change the dropdown for “Database system or older MySQL server to maximize output compatibility with:” from NONE to MYSQL40.
4) Scroll to the bottom and click “GO”.

Cheers!
