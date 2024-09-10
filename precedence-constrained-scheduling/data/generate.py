import random
import sys

time = 60
tasks = 75
processors = 9

fileName = sys.argv[1]
print(f"writing file {fileName}")

with open(fileName+".lp", "w") as f:
  print(f"time(1..{time}).", file=f)
  print(f"task(1..{tasks}).", file=f)
  print(f"processor(1..{processors}).", file=f)
  all = list(range(1, tasks + 1))
  chosen = random.sample(all[:-1], 5*tasks//6)
  chosen.sort()
  for el1 in chosen:
    j = (tasks) // 10 - random.randint(1, 3)
    taken = random.sample(all[el1+1:], min(j, tasks - el1 - 1))
    for el2 in taken:
      print(f"precedes({el1}, {el2}).", file=f)
  
  print("on_proc(T, P) | -on_proc(T, P) :- task(T), processor(P).", file=f)
  print(":- task(T), #count{P : on_proc(T, P)} != 1.", file=f)
  print("at_time(T, K) | -at_time(T, K) :- task(T), time(K).", file=f)
  print(":- task(T), #count{K : at_time(T, K)} != 1.", file=f)
  print(":- task(T1), task(T2), T1 < T2, at_time(T1, K), at_time(T2, K), on_proc(T1, P), on_proc(T2, P).", file=f)
  print(":- precedes(T1, T2), at_time(T1, K1), at_time(T2, K2), K1 >= K2.", file=f)
  print(":~ at_time(T, K). [K@1, K]", file=f)
