1 { v_in(X) : v(X) }.
e_in(X, Y) :- e(X, Y, W), v_in(X), not v_in(Y).
e_in(X, Y) :- e(X, Y, W), v_in(Y), not v_in(X).
#maximize{ W, X, Y : e_in(X, Y), e(X, Y, W) }.
