import re
import sys

def check_html(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Very basic stack-based tag matching for div, span, a, i
    stack = []
    lines = content.split('\n')
    
    # Remove HTML comments to avoid false positives
    content = re.sub(r'<!--.*?-->', '', content, flags=re.DOTALL)
    # Remove blade comments
    content = re.sub(r'\{\{--.*?--\}\}', '', content, flags=re.DOTALL)
    
    # We will match tags 
    tags = re.finditer(r'<\s*(/?)\s*([a-zA-Z0-9]+)([^>]*)>', content)
    for match in tags:
        is_closing = match.group(1) == '/'
        tag_name = match.group(2).lower()
        if tag_name not in ['div', 'span', 'a', 'i', 'button', 'ul', 'li', 'nav', 'header', 'main', 'footer', 'label']:
            continue
            
        # skip self closing tags
        if match.group(3).strip().endswith('/'):
            continue
            
        if is_closing:
            if not stack:
                print(f'Found closing </{tag_name}> but stack is empty!')
            elif stack[-1][0] == tag_name:
                stack.pop()
            else:
                print(f'Found closing </{tag_name}> but expected </{stack[-1][0]}>. Opened at offset {stack[-1][1]}')
        else:
            stack.append((tag_name, match.start()))
                
    if stack:
        print(f'Unclosed tags remaining:')
        for tag, offset in stack:
            print(f'<{tag}> opened at offset {offset}')
    else:
        print('All basic tags matched perfectly!')

check_html('resources/views/layouts/sidebar.blade.php')
