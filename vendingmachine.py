# -*- coding: utf-8 -*-

#Let's take a look at this code and execute it!

#import the function from the utils module to load the automaton
from aalpy.utils import load_automaton_from_file
#import the dfaSUL class from from SULs module
from aalpy.SULs import DfaSUL
#import rWeO class from oracles module
from aalpy.oracles import RandomWalkEqOracle
#import runlstar function from oracles module
from aalpy.learning_algs import run_Lstar


# loading automaton from file
dfa = load_automaton_from_file(path='vendingmachine.dot', automaton_type='dfa')

alphabet = dfa.get_input_alphabet()

#integrate our target system into the active automata learning process
sul = DfaSUL(dfa)

#create instance of the oracle
eq_oracle = RandomWalkEqOracle(alphabet, sul, 500)

#call the run_lstar method that implements the lstar algorithm
learned_dfa = run_Lstar(alphabet, sul, eq_oracle, automaton_type='dfa',
            cache_and_non_det_check=True, cex_processing=None, print_level=3)

#visualize our learned dfa
learned_dfa.visualize()

#Let's see !











