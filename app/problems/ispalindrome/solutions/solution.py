s = input()

s = ' '.join(e for e in s if e.isalnum()).lower()
print(s==s[::-1])