<?php

return [
    'errors' => [
        'not_found' =>[
            'tree' => 'Tree not found.',
            'node' => 'Node not found.',
            'first-node' => 'First node not found.',
            'second-node' => 'Second node not found.',
            'antecesor' => 'Lowest common ancestor not exist.',
        ],
        'empty' => 'The tree is empty.', 
        'insert' => 'An error occurred in the insertion, please try again later, if you feel, contact the administrator.', 
        'update' => 'An error occurred in the upgrade, please try again later, if you feel, contact the administrator.', 
        'delete' => 'An error occurred in the elimination, please try again later, if you feel, contact the administrator.', 
        'origin' => 'The original node is already created.', 
        'insert_node_origin' => 'There was an error inserting the original node. Try it again later; If it continues, contact the administrator.', 
        'insert_node' => 'There was an error inserting the node. Try it again later; If it continues, contact the administrator.', 
        'duplicate_node' => 'Node :node already exists.', 
        'full_node' => 'Node :node is already complete.',
        'update_node' => 'There was an error upgrated the node. Try it again later; If it continues, contact the administrator.', 
    ],
    'message' => [
        'update_tree' => 'Tree updated successfully.',
        'delete_tree' => 'Tree delete successfully.',
        'create_origin' => 'The original node was created.',
        'empty_node' => 'Node empty.',
        'create_node' => 'Node :node was added to the node :node2 correctly.',
        'update_node' => 'Node :node2 was updated to node :node correctly.',
    ]
];
