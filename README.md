#PHP REST API BATTLE SIMULATOR

<b>Description:</b>

The goal of this task is to build an app simulator of the n and 5 battles, between 10 and n armies. The system consists of two functional segments.

1.	REST API for triggering system commands
2.	Battle simulator

<b>API routes</b>
<ul>
<li>Add army: /api/army/create.php</li>
<li>Create a game: /api/game/create.php</li>
<li>Get all games: /api/game/get_all.php</li>
<li>Get game log: /api/game/get_log.php?id={id}</li>
<li>Reset game: /api/game/reset.php?id={id}</li>
<li>Start game: /api/game/start.php?id={id}</li>
</ul>

<b>Simulation of the battle:</b>

Once at least 10 armies have joined, the battle can start. When the start action is called, the armies start to attack.

Attack and strategies:
<ul>
<li>Random: Attack a random army</li>

<li>Weakest: Attack the army with the lowest number of units</li>

<li>Strongest: Attack the army with the highest number of units</li>
</ul>

Attack chances:
Not every attack is successful. Army has 1% of success for every alive unit in it.</li>

Attack damage:
The army always does 0.5 damage per unit, when an attack is successful. 

Received damage:
For every whole point of received damage from the attacking army, one unit is removed from the attacked army.

The army is dead (defeated) when all units are dead. 
The battle is over when there is one army standing.

<b>ADDITIONAL RULES</b>
<ul>
  <li>Armies attack one by one. The order is defined in the order of adding the armies.</li>
  <li>If the new army is added in between turns, it will be added to the beginning of the order, and in the next turn, the army   which was first will now be second and so on.</li>
  <li>Every info about armies is taken from the database before actions. Also after each action, data is stored back in the database.</li>
</ul>

<b>Instructions:</b>
<ul>
<li>Set up a virtual localhost</li>
<li>Import battle_simulator.sql database</li>
<li>Start running attacks!</li>
</ul>
