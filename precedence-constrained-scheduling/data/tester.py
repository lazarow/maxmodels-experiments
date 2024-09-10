import subprocess
import time

for i in range(1, 11):
    while True:        
        start = time.time()
        file_name = f"p{i}"
        subprocess.run(["python3", "generate.py", file_name])
        status = subprocess.run(["timeout", "120", "clingo", f"{file_name}.lp"])
        print(f"status code is {status.returncode}")
        end = time.time()        
        if status.returncode != 124:# and status.returncode == 10:
            if end - start < 30:
                print("repearing too fast")
                continue
            print(f"found problem, file is p{i}.lp")
            break
        print(f"======================")
        print("repeating")
