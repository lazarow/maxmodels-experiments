{ in(X) } :- vtx(X).

:- not inneighbor(X), not in(X), vtx(X).

%inneighbor(X) :- W { in(Y) : edgewt(Y,X,WE), edge(Y,X) = WE }, minweight(W), vtx(X).
%inneighbor(X) :- W { in(Y) : edgewt(X,Y,WE), edge(X,Y) = WE }, minweight(W), vtx(X).

inneighbor(X) :- #sum{ WE,Y,X1 : edgewt(Y,X1,WE), edge(Y,X1), X1=X, in(Y) } >= W, minweight(W), vtx(X).
inneighbor(X) :- #sum{ WE,X1,Y : edgewt(X1,Y,WE), edge(X1,Y), X1=X, in(Y) } >= W, minweight(W), vtx(X).


% the size of the dominating set is at most k
:- K+1 { in(X) : vtx(X) }, bound(K).

#minimize { 1, X: in(X) }.
