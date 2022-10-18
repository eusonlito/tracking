<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Action\Traits\SaveRow as SaveRowTrait;
use App\Domains\Trip\Model\Trip as Model;

class UpdateMerge extends ActionAbstract
{
    use SaveRowTrait;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->delete();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataIds();
    }

    /**
     * @return void
     */
    protected function dataIds(): void
    {
        $this->data['ids'] = Model::byUserId($this->auth->id)
            ->byIdNot($this->row->id)
            ->byIds($this->data['ids'])
            ->pluck('id')
            ->all();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (empty($this->data['ids'])) {
            $this->exceptionValidator(__('trip-update-merge.error.ids-empty'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->savePoints();
        $this->saveRow();
    }

    /**
     * @return void
     */
    protected function savePoints(): void
    {
        PositionModel::byTripIds($this->data['ids'])
            ->byIdNot($this->row->id)
            ->update(['trip_id' => $this->row->id]);
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->saveRowStartEnd();
        $this->saveRowName();
        $this->saveRowSave();
        $this->saveRowDistanceTime();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        Model::byIds($this->data['ids'])->delete();
    }
}
