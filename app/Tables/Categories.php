<?php

namespace App\Tables;

use App\Models\Category;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;

class Categories extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Category::query();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(columns: ['name'])
            ->column('id', sortable: true)
            ->column('name', sortable: true, canBeHidden: false)
            ->column('slug')
            ->column('updated_at')
            ->column('action', exportAs: false)
            ->bulkAction(
                label: 'Touch Timestamp',
                each: fn (Category $category) => $category->touch(),
                after: fn () => Toast::info('Timestamp Updated!')
            )
            ->bulkAction(
                label: 'Delete Categories',
                each: fn (Category $category) => $category->delete(),
                after: fn () => Toast::info('Categories Deleted!')
            )
            ->export()
            ->paginate(5);

            // ->searchInput()
            // ->selectFilter()
            // ->withGlobalSearch()

            // ->bulkAction()
            // ->export()
    }
}
