import sys

ptxt = sys.argv[1]
ctxt = ""
for k in range(1, 26):
	ctxt = ""
	for ch in ptxt:
		base = 97 if ord(ch) > 91 else 65
		x = (ord(ch) - base + k) % 26 + base
		ctxt += chr(x)
	print '{} : {:02d}'.format(ctxt, k)

