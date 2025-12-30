<?php
declare(strict_types=1);
namespace App\Forms\Fields;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyRelation;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Concerns\AsInput;
class BelongsToManyCheckbox extends Field
{
    use AsInput;
    protected mixed $view = 'admin.components.form.fields.belongs_to_many_checkbox';
    public mixed $options = [];
    public mixed $relationship = null;
    public mixed $relationshipTitleAttribute = 'name';
    public mixed $gridColumns = 3;
    public function options(array $options): static
    {
        $this->options = $options;
        return $this;
    }
    public function gridColumns(int $gridColumns): static
    {
        $this->gridColumns = $gridColumns;
        return $this;
    }
    public function relationship($name = null, $titleAttribute = 'name'): static
    {
        $this->relationship = $name ?: $this->getName();
        $this->relationshipTitleAttribute = $titleAttribute;
        return $this;
    }
    public function getOptions(): array
    {
        if (!empty($this->options)) {
            return $this->options;
        }
        if (!empty($this->relationship)) {
            $model = $this->getModel();
            if ($model && method_exists($model, $this->relationship)) {
                $relation = $model->{$this->relationship}();
                $relatedModel = $relation->getRelated();
                $title = $this->relationshipTitleAttribute;
                $key = $relatedModel->getKeyName();
                return $relatedModel::query()->get()->pluck($title, $key)->toArray();
            }
        }
        return [];
    }
    public function getValue(): mixed
    {
        if (!is_null($this->value)) {
            $value = $this->evaluate($this->value);
            return is_array($value) ? $value : [];
        }
        $model = $this->getModel();
        // Check if model exists and has an ID (not a new model)
        if ($model && $model->exists && !empty($this->relationship) && method_exists($model, $this->relationship)) {
            $relation = $model->{$this->relationship}();
            if ($relation instanceof BelongsToManyRelation) {
                $relatedTable = $relation->getRelated()->getTable();
                $relatedKey = $relation->getRelatedKeyName();
                return $relation->pluck($relatedTable . '.' . $relatedKey)->toArray();
            }
        }
        if ($model) {
            $value = data_get($model, $this->getName());
            return is_array($value) ? $value : [];
        }
        return [];
    }
    public function save($model)
    {
        if (!empty($this->relationship)) {
            return $model;
        }
        $model->{$this->getName()} = $this->getDataFromRequest() ?? [];
        return $model;
    }
    public function getRelationship()
    {
        return $this->relationship;
    }
    public function saveRelationship($model)
    {
        if (empty($this->relationship)) {
            return;
        }
        $relation = $model->{$this->relationship}();
        if ($relation instanceof BelongsToManyRelation) {
            $relation->sync($this->getDataFromRequest() ?? []);
        }
    }
}
