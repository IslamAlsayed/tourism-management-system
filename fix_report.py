import re

path = r'g:\MixJo Top downlode mains by dats\for edit\tourism-management-system  13 FEB 2026 0221AM\tourism-management-system\create_unified_report.py'

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Add Bug #15 row after Bug #14 in the summary table
old = "['14', 'MySQL Strict Mode / GROUP BY\\\\n\u0648\u0636\u0639 MySQL \u0627\u0644\u0635\u0627\u0631\u0645', 'Server Config', '\U0001f534 Critical', '1'],\r\n    ]"
new = "['14', 'MySQL Strict Mode / GROUP BY\\\\n\u0648\u0636\u0639 MySQL \u0627\u0644\u0635\u0627\u0631\u0645', 'Server Config', '\U0001f534 Critical', '1'],\r\n        ['15', 'Missing Cron Job / Scheduler\\\\n\u0639\u062f\u0645 \u0648\u062c\u0648\u062f Cron Job', 'Server Ops', '\U0001f534 Critical', '0'],\r\n    ]"

if old in content:
    content = content.replace(old, new)
    with open(path, 'w', encoding='utf-8', newline='') as f:
        f.write(content)
    print("SUCCESS: Bug #15 row added to summary table")
else:
    print("WARNING: Target string not found, checking...")
    # Try without \r\n
    old2 = old.replace('\r\n', '\n')
    new2 = new.replace('\r\n', '\n')
    if old2 in content:
        content = content.replace(old2, new2)
        with open(path, 'w', encoding='utf-8') as f:
            f.write(content)
        print("SUCCESS (LF): Bug #15 row added")
    else:
        print("FAILED: Could not find target")
