import pydot
import networkx as nx
import sys
import numpy as np


fileName = sys.argv[1]
print(f"writing file {fileName}")

node_count = 30
edge_count = 110

idx_from = set()
idx_to = set()

while True:
    G = nx.gnm_random_graph(node_count, edge_count, directed=True)
    for e1, e2 in G.edges:        
        idx_from.add(e1)
        idx_to.add(e2)
    
    if len(idx_from) == node_count == len(idx_to):
        break

footer = \
"""

{in(I, J)} :- e(I, J, W).
r(X) :- source(X).
r(Y) :- in(X, Y), source(X).
r(Y) :- in(X, Y), r(X).
:- not r(X), target(X).
:- v(X), 2 {in(X, Y)}.
:- v(Y), 2 {in(X, Y)}.
:- in(X, Y), target(X).
:- in(X, Y), source(Y).
:- in(X, Y), not r(X).
#maximize{ W, I, J : in(I, J), e(I, J, W) }.
"""

with open(fileName+".lp", "w") as f:
    print(f"v(0..{len(G.nodes)-1}).", file=f)
    print(f"source(0).", file=f)
    print(f"target({len(G.nodes)-1}).", file=f)    
    for e1, e2 in G.edges:
        w = np.random.randint(1,10)*1000
        print(f"e({e1}, {e2}, {w}).", file=f)
    print(footer, file=f)
