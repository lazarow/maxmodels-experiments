%{in(C)} :- subset(C).
in(C) :- subset(C), not not_in(C).
not_in(C) :- subset(C), not in(C).
#minimize{1, C : in(C)}.
