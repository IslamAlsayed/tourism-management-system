@echo off
echo =======================================================
echo Pushing all changes to GitHub (Account: Tawfiqmakhamreh, branch: emix37)
echo =======================================================

echo [Disabling broken credential manager...]
git config --local credential.helper ""

echo 1. Adding all files to staging...
git add .

echo 2. Committing changes...
git commit -m "Upload all project modifications - emix37 branch"

echo 3. Switching to branch emix37...
git branch -M emix37

echo 4. Pushing to remote...
:: We use the exact URL but with https so it forces token login if SSH isn't set up.
git push https://github.com/Tawfiqmakhamreh/tourism-management-system.git HEAD:emix37

echo =======================================================
echo Done! Please review any error messages above if it failed.
echo =======================================================
pause
