# -*- coding: utf-8 -*-
"""Check all audit URLs automatically"""
import requests

LOGIN_URL = 'https://mixjo.top/login'
BASE = 'https://mixjo.top/dashboard'

# All URLs from the audit report that had errors
URLS = [
    # Core - Users (were 500)
    (f'{BASE}/core/users/create', 'Core Users Create'),
    (f'{BASE}/core/users/1', 'Core Users View'),
    (f'{BASE}/core/users/1/edit', 'Core Users Edit'),
    # Core - Roles (were 500)
    (f'{BASE}/core/roles/create', 'Core Roles Create'),
    (f'{BASE}/core/roles/1/edit', 'Core Roles Edit'),
    # Core - Permissions (were 500)
    (f'{BASE}/core/permissions/create', 'Core Permissions Create'),
    (f'{BASE}/core/permissions/1/edit', 'Core Permissions Edit'),
    # Core - Reports (NOT TESTED)
    (f'{BASE}/core/reports', 'Core Reports'),
    # Geography - Views (were 500)
    (f'{BASE}/geography/regions/1', 'Regions View'),
    (f'{BASE}/geography/subregions/1', 'Subregions View'),
    (f'{BASE}/geography/countries/1', 'Countries View'),
    # Geography - Timeout
    (f'{BASE}/geography/states', 'States List'),
    (f'{BASE}/geography/cities', 'Cities List'),
    # Localization (were 500)
    (f'{BASE}/localization/languages', 'Languages'),
    (f'{BASE}/localization/system-languages', 'System Languages'),
    (f'{BASE}/localization/currencies', 'Currencies'),
    (f'{BASE}/localization/timezones', 'Timezones'),
    # Tour Guides (were 419)
    (f'{BASE}/tourguides/guides-types/create', 'Guide Types Create'),
    (f'{BASE}/tourguides/guides-reviews', 'Guide Reviews'),
    # Accommodations
    (f'{BASE}/accommodations/create', 'Accommodations Create'),
    # Restaurants (were 500)
    (f'{BASE}/restaurants', 'Restaurants List'),
    (f'{BASE}/restaurants/create', 'Restaurants Create'),
    # Transportation (were 500/FAIL)
    (f'{BASE}/transportation/companies/1', 'Transport Company View'),
    (f'{BASE}/transportation/pricings', 'Transport Pricings'),
    # Travel Documents (were 500)
    (f'{BASE}/traveldocuments/visa-requirements/create', 'Visa Req Create'),
    # Entry Points (were 500)
    (f'{BASE}/entrypoints/land-crossings', 'Land Crossings'),
    (f'{BASE}/entrypoints/seaports', 'Sea Ports'),
    (f'{BASE}/entrypoints/airports', 'Airports'),
    # Airlines (was 500)
    (f'{BASE}/airlines', 'Airlines List'),
]

session = requests.Session()
session.headers.update({'User-Agent': 'Mozilla/5.0'})

# Get CSRF token
print("Logging in...")
resp = session.get(LOGIN_URL, timeout=15)
import re
csrf = re.search(r'name="_token"\s+value="([^"]+)"', resp.text)
if not csrf:
    csrf = re.search(r'"_token":\s*"([^"]+)"', resp.text)
if csrf:
    token = csrf.group(1)
    login_resp = session.post(LOGIN_URL, data={
        '_token': token,
        'email': 'tawfiq@example.com',
        'password': '12345678',
    }, timeout=15, allow_redirects=True)
    print(f"Login status: {login_resp.status_code}, URL: {login_resp.url}")
else:
    print("Could not find CSRF token!")

print("\n" + "="*80)
print(f"{'URL':<55} {'Name':<25} {'Status'}")
print("="*80)

results = {'OK': [], '500': [], '404': [], '419': [], 'TIMEOUT': [], 'OTHER': []}

for url, name in URLS:
    try:
        r = session.get(url, timeout=20, allow_redirects=True)
        code = r.status_code
        # Check for error text in page
        has_error = 'Server Error' in r.text or 'Internal Server Error' in r.text
        has_500 = '500' in r.text[:500] and has_error
        
        if code == 200 and not has_error:
            status = 'OK'
        elif code == 200 and has_error:
            status = '500 (in body)'
        elif code == 500:
            status = '500'
        elif code == 404:
            status = '404'
        elif code == 419:
            status = '419'
        else:
            status = str(code)
        
        cat = '500' if '500' in status else ('404' if '404' in status else ('419' if '419' in status else ('OK' if status == 'OK' else 'OTHER')))
        results[cat].append((name, url, status))
        print(f"{url:<55} {name:<25} {status}")
    except requests.Timeout:
        results['TIMEOUT'].append((name, url, 'TIMEOUT'))
        print(f"{url:<55} {name:<25} TIMEOUT")
    except Exception as e:
        results['OTHER'].append((name, url, str(e)[:30]))
        print(f"{url:<55} {name:<25} ERROR: {str(e)[:50]}")

print("\n" + "="*80)
print("SUMMARY:")
for cat, items in results.items():
    if items:
        print(f"\n{cat} ({len(items)}):")
        for name, url, status in items:
            print(f"  - {name}: {status}")
