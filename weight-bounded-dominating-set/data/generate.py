import networkx as nx
import random
import argparse

random.seed()

parser = argparse.ArgumentParser(description="Data generation tool for the weighted dominating set problem.")
parser.add_argument('--n', type=int, help="Number of vertices")
parser.add_argument('--m', type=int, help="Number of edges")
parser.add_argument('--f', type=str, help="Name of the output file")
args = parser.parse_args()
n, m = args.n, args.m
seed = random.randint(1, 4000000000)
graph = nx.gnm_random_graph(n, m, seed, directed=True)

bound = random.randint(5, n//5) 
minweight = random.randint(5, 60)

with open(args.f, 'w') as file:
    file.write(f"bound({bound}).\n")
    file.write(f"minweight({minweight}).\n")
    for (s, d) in graph.edges():
        file.write(f"edge({s},{d}).\n")
    for (s, d) in graph.edges():
        w = random.randint(1, 50)
        file.write(f"edgewt({s},{d},{w}).\n")
    file.write(f"vtx(0..{n - 1}).\n")
