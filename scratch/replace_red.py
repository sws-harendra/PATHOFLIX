import os
import re

def replace_in_file(file_path):
    with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    orig = content
    content = re.sub(r'#dc2626', '#C70000', content, flags=re.IGNORECASE)

    if content != orig:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated: {file_path}")

exclude_dirs = {'.git', 'node_modules', 'vendor', 'storage', 'bootstrap'}

for root, dirs, files in os.walk('d:/PATHOFLIX'):
    dirs[:] = [d for d in dirs if d not in exclude_dirs]
    for file in files:
        if file.endswith(('.php', '.css', '.js', '.json')):
            if file == 'replace_red.py':
                continue
            replace_in_file(os.path.join(root, file))
