# State Machine Package

## User story

To ensure correct tracking and updating of each status of each each order, it is necessary to implement the State design pattern.
This package will implement the state design pattern on the Orders model.
## Package Details

This package will expose a trait to easily implement it with other Eloquent Models.

## Config

Use vendor publish command to publish the config file and graph files.
The default graph file location is "storage/state_machine_graphs". You can change the folder name via the config file.
```cmd
php artisan vendor:publish
```
It will be published to config/state_machine.php.
By default, there will two graphs published. 
- main_graph - Reflects the "order_statues" database table.
- sample_graph - Reflects the sample graph publish in the "Pet Shop developer documentation"

## Usage
- Use StateMachine trait by importing the trait.

```php
use Ashan\StateMachine\Traits\StateMachine;

class Order extends Model
{
    use StateMachine;
}
```
- Update your graph file to reflect your model.
````json
{
    "graph": "main_graph (Graph Name)",
    "property_path": "order_status_state (Current state will be save in your model's property path. Datatype is Ashan\\StateMachine\\Models\\State)",
    "state_primary_key": "uuid (The primary key of the states in this file.)",
    "property_id": "order_status_uuid (The model's property path to save the primary key data.)",
    "states": [
        {
            "title": "open",
            "uuid": "8fe0053a-6bbe-34e7-820f-19812a6e62e5",
            "initial": true
        },
        {
            "title": "pending payment",
            "uuid": "c1229f0c-af35-3a36-8c9b-a54830529a52"
        },
        {
            "title": "paid",
            "uuid": "41c92f2b-2d6d-34e3-a792-9e80d3ae4bc3"
        },
        {
            "title": "shipped",
            "uuid": "d2c9b721-13c3-35ba-a0b5-10e683958608"
        },
        {
            "title": "canceled",
            "uuid": "56e42c2d-1311-3f8f-b670-6ebe1ff50768"
        }],
    "transitions":
    {
        "open": [
            {
                "from": "open",
                "to": ["pending payment","paid"]
            }],
        "pending payment": [
            {
                "from": "pending payment",
                "to": ["paid", "canceled"]
            }],
        "paid": [
            {
                "from": "paid",
                "to": ["shipped", "canceled"]
            }],
        "shipped": [
            {
                "from": "shipped",
                "to": ["canceled"]
            }],
        "canceled": [
            {
                "from": "canceled",
                "to": ["canceled"]
            }]
    }
}
````
Call $model->setGraph("graph_file_name"); to set the graph.

## Available Functions

````
setGraph($filename)
getGraph()
getPrimaryKeyName()

getCurrentState()
getNextTransitions()

process($nextTransition)
setCurrentStateByStatePrimaryKey($primaryKey, $force = false)

can(string $nextTransition)
canChangeStateByPrimaryKey(string $primaryKey)
canChangeStateByTitle(string $title)
````
## Exceptions
If transitions is invalid according to the state, StateMachineException will be thrown.

## Testing

Tests can be directly executed through the following command from main project.

    php artisan test

## Extra
If the $model is new, the state with the "initial" flag will be assigned from the states.
If the $model is loaded, the state will reflect the state fetched through 'property_id' field.

## Tinker output with sample_graph.
```cmd
php artisan tinker
Psy Shell v0.11.8 (PHP 8.1.8 — cli) by Justin Hileman
>>> $model = new \App\Models\Order();
=> App\Models\Order {#3647
     #order_status_state: null,
   }

>>> $model->setGraph("sample_graph");
=> null

>>> dump($model->getCurrentState());
Ashan\StateMachine\Models\State {#3652
  -name: "state_0"
  -metadata: {#3642
    +"title": "state_0"
    +"uuid": "6ea65f69-e45d-409e-b740-9a18e7060cbd"
    +"initial": true
  }
}
=> Ashan\StateMachine\Models\State {#3652}

>>> dump($model->getNextTransitions());
array:3 [
  "state_0_to_state_0" => Ashan\StateMachine\Models\Transition {#3666
    -name: "state_0_to_state_0"
    -initialStateName: "state_0"
    -resultingStateName: "state_0"
    -metadata: {#3649
      +"from": "state_0"
      +"to": array:3 [
        0 => "state_0"
        1 => "state_1"
        2 => "state_2"
      ]
    }
  }
  "state_0_to_state_1" => Ashan\StateMachine\Models\Transition {#3667
    -name: "state_0_to_state_1"
    -initialStateName: "state_0"
    -resultingStateName: "state_1"
    -metadata: {#3649}
  }
  "state_0_to_state_2" => Ashan\StateMachine\Models\Transition {#3663
    -name: "state_0_to_state_2"
    -initialStateName: "state_0"
    -resultingStateName: "state_2"
    -metadata: {#3649}
  }
]
=> [
     "state_0_to_state_0" => Ashan\StateMachine\Models\Transition {#3666},
     "state_0_to_state_1" => Ashan\StateMachine\Models\Transition {#3667},
     "state_0_to_state_2" => Ashan\StateMachine\Models\Transition {#3663},
   ]

>>> $model->process('state_0_to_state_1')
=> true

>>> dump($model->getCurrentState());
Ashan\StateMachine\Models\State {#3650
  -name: "state_1"
  -metadata: {#3646
    +"title": "state_1"
    +"uuid": "727abfdd-b726-4dac-a14e-241d9616dc4a"
  }
}
=> Ashan\StateMachine\Models\State {#3650}

>>> dump($model->getNextTransitions());
array:3 [
  "state_1_to_state_0" => Ashan\StateMachine\Models\Transition {#3670
    -name: "state_1_to_state_0"
    -initialStateName: "state_1"
    -resultingStateName: "state_0"
    -metadata: {#3656
      +"from": "state_1"
      +"to": array:3 [
        0 => "state_0"
        1 => "state_1"
        2 => "state_2"
      ]
    }
  }
  "state_1_to_state_1" => Ashan\StateMachine\Models\Transition {#3665
    -name: "state_1_to_state_1"
    -initialStateName: "state_1"
    -resultingStateName: "state_1"
    -metadata: {#3656}
  }
  "state_1_to_state_2" => Ashan\StateMachine\Models\Transition {#3652
    -name: "state_1_to_state_2"
    -initialStateName: "state_1"
    -resultingStateName: "state_2"
    -metadata: {#3656}
  }
]
=> [
     "state_1_to_state_0" => Ashan\StateMachine\Models\Transition {#3670},
     "state_1_to_state_1" => Ashan\StateMachine\Models\Transition {#3665},
     "state_1_to_state_2" => Ashan\StateMachine\Models\Transition {#3652},
   ]

>>>
```
-------------------
Copyright © 2022 Ashan Beruwalage - Developed with ♥


