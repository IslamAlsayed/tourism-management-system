@echo off
echo Restoring 8 translation languages...

set SRC=g:\MixJo Top downlode mains by dats\for edit\Translate mixjo VS Code\lang - Copy
set DEST=g:\MixJo Top downlode mains by dats\for edit\tourism-management-system  13 FEB 2026 0221AM\tourism-management-system\resources\lang

echo Restoring German (de)...
xcopy /E /I /Y "%SRC%\de" "%DEST%\de"

echo Restoring Spanish (es)...
xcopy /E /I /Y "%SRC%\es" "%DEST%\es"

echo Restoring French (fr)...
xcopy /E /I /Y "%SRC%\fr" "%DEST%\fr"

echo Restoring Hebrew (he)...
xcopy /E /I /Y "%SRC%\he" "%DEST%\he"

echo Restoring Italian (it)...
xcopy /E /I /Y "%SRC%\it" "%DEST%\it"

echo Restoring Japanese (ja)...
xcopy /E /I /Y "%SRC%\ja" "%DEST%\ja"

echo Restoring Russian (ru)...
xcopy /E /I /Y "%SRC%\ru" "%DEST%\ru"

echo Restoring Turkish (tr)...
xcopy /E /I /Y "%SRC%\tr" "%DEST%\tr"

echo.
echo Translation files restored successfully!
pause
