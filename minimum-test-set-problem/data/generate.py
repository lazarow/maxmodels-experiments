import random
import sys

fileName = sys.argv[1]
print(f"writing file {fileName} series")
s = 23
m = 56
universum = list(range(s))
collection = []
for i in range(m):
    collection.append(random.sample(universum, random.randint(3, 7)))

with open(fileName+".in", "w") as f:
    print(f"universum: {s}", file=f)
    print("collection:", file=f)
    for i in range(m):
        print(f"- [{collection[i][0]}", end="", file=f)
        for j in range(1, len(collection[i])):
            print(f", {collection[i][j]}", end="", file=f)
        print("]", file=f)

with open(fileName+".lp", "w") as f:
    print(f"subset(0..{m-1}).", file=f)
    print(f"s(0..{s-1}).", file=f)
    for i in range(m):
        for j in collection[i]:
            print(f"c({i}, {j}).", file=f)
    print("{in(C)} :- subset(C).", file=f)
    print(":- s(S1), s(S2), S1 < S2, {in(C) : c(C, S1), not c(C, S2)} = 0, {in(C) : c(C, S2), not c(C, S1)} = 0.", file=f)
    print("#minimize{1, C : in(C)}.", file=f)

with open(fileName+".dl", "w") as f:
    print(f"s(0..{s-1}).", file=f)
    for i in range(m):
        for j in collection[i]:
            print(f"c({i}, {j}).", file=f)
    print(f"subset(0..{m-1}).", file=f)
    print("in(C) | -in(C) :- subset(C).", file=f)
    print(":- s(S1), s(S2), S1 < S2, #count{C : in(C), c(C, S1), not c(C, S2)} = 0, #count{C : in(C), c(C, S2), not c(C, S1)} = 0.", file=f)
    print(":~ in(C). [1@1, C]", file=f)
