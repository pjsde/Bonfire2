<?php namespace Bonfire\Libraries\Menus;

class Menu
{
	/**
	 * Holds all items/collections that appear
	 * at top level in this menu.
	 *
	 * @var array
	 */
	protected $items = [];

	/**
	 * Returns all items/collections in the menu.
	 *
	 * @return array
	 */
	public function items()
	{
		return $this->items;
	}

	/**
	 * Adds a new item
	 *
	 * @param MenuItem $item
	 *
	 * @return $this
	 */
	public function addItem(MenuItem $item)
	{
		$this->items[] = $item;

		return $this;
	}

	/**
	 * Creates a new collection with default values for
	 * everything except the `name` and `title`, which are
	 * required parameters.
	 *
	 * @param string $name
	 * @param string $title
	 *
	 * @return MenuCollection
	 */
	public function createCollection(string $name, string $title): MenuCollection
	{
		$collection = new MenuCollection();
		$collection->setName($name)
			->setTitle($title);

		$this->items[] = $collection;

		return $collection;
	}

	/**
	 * Creates a new collection, if one with $name doesn't exist,
	 * and adds the items to the collection.
	 *
	 * @param string $name
	 * @param array  $items
	 *
	 * @return MenuCollection|mixed
	 */
	public function collect(string $name, array $items)
	{
		$collection = $this->collection($name);

		if ($collection === null)
		{
			$collection = new MenuCollection();
			$collection->setName($name)->setTitle(ucfirst($name));

			$this->items[] = $collection;
		}

		$collection->addItems($items);

		return $collection;
	}

	/**
	 * Locates a collection by name.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function collection(string $name)
	{
		foreach ($this->items as $item)
		{
			if ($item instanceof MenuCollection && $item->name() === $name)
			{
				return $item;
			}
		}
	}

    /**
     * Returns an array of all collections stored, if any.
     *
     * @return array
     */
    public function collections(): array
    {
        $collections = [];

        foreach ($this->items as $item) {
            if ($item instanceof MenuCollection) {
                $collections[] = $item;
            }
        }

        return $collections;
	}
}
