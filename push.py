import sys
import os
if len(sys.argv) < 2:
    print("please give the arguments correctly.")
else:
    msg = sys.argv[1]
    os.system("git add .")
    os.system('git commit -m "'+msg+'"')
    os.system("push")

