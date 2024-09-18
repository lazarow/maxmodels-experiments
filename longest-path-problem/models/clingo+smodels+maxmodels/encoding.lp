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
