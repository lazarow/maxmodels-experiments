import subprocess

for i in range(2, 11):
    while True:        
        file_name = f"p{i}"
        subprocess.run(["python3", "generate.py", file_name])
        status = subprocess.run(["timeout", "120", "clingo", f"{file_name}.lp"])
        print(f"status code is {status.returncode}")
        if status.returncode != 124:
            print(f"found problem, file is p{i}.lp")
            break
        print(f"======================")
        print("repeating")
