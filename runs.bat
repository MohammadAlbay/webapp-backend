@echo OFF
start cmd /k "php artisan serve"
start cmd /K "C:\Users\Moham\Desktop\gp24\webapp-technician\MailHog_windows_amd64.exe"
start cmd /k "php artisan schedule:work > NUL 2>&1"