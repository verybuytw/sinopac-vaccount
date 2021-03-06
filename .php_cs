<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude('vendor')
    ->exclude('tests')
    ->exclude('storage')
    ->exclude('resources')
    ->exclude('public')
    ->exclude('database')
    ->exclude('config')
    ->exclude('bootstrap')
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
            ->setUsingCache(true)
            ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
            ->fixers(array(
                '-psr0',
                'blankline_after_open_tag',
                'braces',
                'concat_without_spaces',
                'double_arrow_multiline_whitespaces',
                'duplicate_semicolon',
                'elseif',
                'empty_return',
                'encoding',
                'eof_ending',
                'extra_empty_lines',
                'function_call_space',
                'function_declaration',
                'include',
                'indentation',
                'linefeed',
                'join_function',
                'line_after_namespace',
                'list_commas',
                'logical_not_operators_with_successor_space',
                'lowercase_constants',
                'lowercase_keywords',
                'method_argument_space',
                'multiline_array_trailing_comma',
                'multiline_spaces_before_semicolon',
                'multiple_use',
                'namespace_no_leading_whitespace',
                'no_blank_lines_after_class_opening',
                'no_empty_lines_after_phpdocs',
                'object_operator',
                'operators_spaces',
                'parenthesis',
                'remove_leading_slash_use',
                'remove_lines_between_uses',
                'return',
                'self_accessor',
                'short_array_syntax',
                'short_echo_tag',
                'short_tag',
                'single_array_no_trailing_comma',
                'single_blank_line_before_namespace',
                'single_line_after_imports',
                'single_quote',
                'spaces_before_semicolon',
                'spaces_cast',
                'standardize_not_equal',
                'ternary_spaces',
                'trailing_spaces',
                'trim_array_spaces',
                'unalign_equals',
                'unary_operators_spaces',
                'unused_use',
                'visibility',
                'whitespacy_lines',
            ))
            ->finder($finder);
