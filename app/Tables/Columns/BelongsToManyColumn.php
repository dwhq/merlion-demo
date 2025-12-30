<?php
declare(strict_types=1);
namespace App\Tables\Columns;
use Merlion\Components\Table\Columns\Column;
class BelongsToManyColumn extends Column
{
    protected mixed $view = 'admin.components.table.columns.belongs_to_many';
    public mixed $relationship = null;
    public mixed $displayAttribute = 'display_name';
    public mixed $limit = 3;
    public function relationship($name = null, $displayAttribute = 'display_name'): static
    {
        $this->relationship = $name ?: $this->getName();
        $this->displayAttribute = $displayAttribute;
        return $this;
    }
    public function limit(int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }
    public function displayAttribute(string $attribute): static
    {
        $this->displayAttribute = $attribute;
        return $this;
    }
    public function getRelatedItems(): array
    {
        $model = $this->getModel();
        if (!$model) {
            return [];
        }
        $relationName = $this->relationship ?: $this->getName();
        if (method_exists($model, $relationName)) {
            return $model->{$relationName}->toArray();
        }
        return [];
    }
}
