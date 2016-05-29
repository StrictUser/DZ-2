#!/user/bin/php

<?php

	class LiftClass
	{
		public $currentPassengers = 0;
		public $currentFloor = 1;

		public function printCurrentState()
		{
			echo "Текущий этаж: " . $this->currentFloor . ". Текущее количество пассажиров: " . $this->currentPassengers . PHP_EOL;
		}

		public function getNextFloor($floor)
		{
			try
			{
				if ($floor > 9 or $floor < 1)
				{
					throw new ErrorClass('Введен неверный этаж. В здании всего 9 этажей. ', 3);
				}
				else
				{
					$this->currentFloor = $floor;
				}
			}
			catch (ErrorClass $e)
			{
				echo $e->errmessage();
			}
			return $this->currentFloor;
		}

		public function checkInPassengers($floor, $passengersIn)
		{
			try
			{
				if ($floor > 9 or $floor < 1)
				{
					throw new ErrorClass('Введен неверный этаж. В здании всего 9 этажей. ', 2);
				}
				else
				{
					try
					{
						if ($this->currentPassengers + $passengersIn > 4)
						{
							throw new ErrorClass('Превышен лимит грузоподъемности!', 1);
						}
						else
						{
							$this->currentFloor = $floor;
							$this->currentPassengers += $passengersIn;
						}
					}
					catch (ErrorClass $e)
					{
						echo $e->errmessage() . PHP_EOL;
					}
				}
			}
			catch (ErrorClass $e)
			{
				echo $e->errmessage() . PHP_EOL;
			}

			return $this->currentPassengers;
		}

		public function checkOutPassengers()
		{
			$out = $this->currentPassengers;

			$this->currentPassengers -= $out;

			echo "Лифт прибыл на: " . $this->currentFloor . " этаж, вышло " . $out . PHP_EOL;
		}
	}

	class ErrorClass extends \Exception
	{

		public function __construct($message, $code, \Exception $previous = NULL)
		{
			parent::__construct($message, $code, $previous);
		}

		public function errmessage()
		{
			return "Вы получили ошибку: " . $this->message;
		}

	}

	function clean($data)
	{
		$query = strip_tags($data);
		$query = htmlentities($query);
		$query = stripslashes($query);

		return $query;
	}

	echo "Сейчас лифт находится на 1-м этаже. Он пуст." . PHP_EOL;

	$lift = new LiftClass();

	do
	{
		echo "Введите необходимый этаж:" . PHP_EOL;
		$floor = (int)clean(fgets(STDIN));
		$lift->getNextFloor($floor);
	}
	while($floor < 1 || $floor > 9);

	do
	{
		$lift->currentPassengers = 0;
		echo "Какое количество человек входит?" . PHP_EOL;
		$passengersIn = (int)clean(fgets(STDIN));
		$lift->checkInPassengers($floor, $passengersIn);
	}
	while($passengersIn > 4);



	$lift->checkOutPassengers();

	$lift->printCurrentState();