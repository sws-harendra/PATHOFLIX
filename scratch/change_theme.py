import os
import re

replacements = {
    '#0c5f56': '#dc2626', # primary teal -> red-600
    '#094d45': '#b91c1c', # hover teal -> red-700
    '#073d36': '#991b1b', # dark hover teal -> red-800
    '#0f2d2a': '#18181b', # dark green text -> zinc-900
    '#0b1f1d': '#0f172a', # dark footer background -> slate-900
    '#f4f7f6': '#ffffff', # light background -> white
    'rgba(12, 95, 86,': 'rgba(220, 38, 38,', # falling particle color -> red-600 rgb
    'teal-950': 'red-950',
    'teal-900': 'red-900',
    'teal-800': 'red-800',
    'teal-700': 'red-700',
    'teal-600': 'red-600',
    'teal-500': 'red-500',
    'teal-400': 'red-400',
    'teal-300': 'red-300',
    'teal-200': 'red-200',
    'teal-100': 'red-100',
    'teal-50': 'red-50',
    'teal-custom': 'red-custom',
    'bg-teal-custom': 'bg-red-600',
    '#17a2b8': '#dc2626', # teal custom color -> red-600
    '#0284c7': '#dc2626', # blue primary -> red-600
    
    # Emerald color mappings
    'emerald-950': 'red-950',
    'emerald-900': 'red-900',
    'emerald-800': 'red-800',
    'emerald-700': 'red-700',
    'emerald-650': 'red-600',
    'emerald-600': 'red-600',
    'emerald-500': 'red-500',
    'emerald-400': 'red-400',
    'emerald-300': 'red-300',
    'emerald-250': 'red-200',
    'emerald-200': 'red-200',
    'emerald-100': 'red-100',
    'emerald-50': 'red-50',
    'emerald-': 'red-',
    'bg-emerald-': 'bg-red-',
    'text-emerald-': 'text-red-',
    'border-emerald-': 'border-red-',

    # Green color mappings
    '#28a745': '#dc2626', # bootstrap green -> red-600
    'green-950': 'red-950',
    'green-900': 'red-900',
    'green-800': 'red-800',
    'green-700': 'red-700',
    'green-600': 'red-600',
    'green-500': 'red-500',
    'green-400': 'red-400',
    'green-300': 'red-300',
    'green-250': 'red-200',
    'green-200': 'red-200',
    'green-100': 'red-100',
    'green-50': 'red-50',
    'text-green-': 'text-red-',
    'bg-green-': 'bg-red-',
    'border-green-': 'border-red-',
}

def replace_in_file(file_path):
    with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    orig = content
    for old, new in replacements.items():
        content = re.sub(re.escape(old), new, content, flags=re.IGNORECASE)
    
    # Specific case for app.css theme brand colors
    if 'app.css' in file_path:
        content = content.replace('--color-brand-50: #f0f9ff;', '--color-brand-50: #fef2f2;')
        content = content.replace('--color-brand-100: #e0f2fe;', '--color-brand-100: #fee2e2;')
        content = content.replace('--color-brand-200: #bae6fd;', '--color-brand-200: #fecaca;')
        content = content.replace('--color-brand-500: #0ea5e9;', '--color-brand-500: #ef4444;')
        content = content.replace('--color-brand-600: #0284c7;', '--color-brand-600: #dc2626;')
        content = content.replace('--color-brand-700: #0369a1;', '--color-brand-700: #b91c1c;')
        content = content.replace('--color-brand-900: #0c4a6e;', '--color-brand-900: #7f1d1d;')

    if content != orig:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated: {file_path}")

exclude_dirs = {'.git', 'node_modules', 'vendor', 'storage', 'bootstrap'}

for root, dirs, files in os.walk('d:/PATHOFLIX'):
    dirs[:] = [d for d in dirs if d not in exclude_dirs]
    for file in files:
        if file.endswith(('.php', '.css', '.js', '.json')):
            if file == 'change_theme.py':
                continue
            replace_in_file(os.path.join(root, file))
