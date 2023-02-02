<?php

namespace App\Tables;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;

class Posts extends AbstractTable
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
        return Post::query();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $globarSearch = AllowedFilter::callback('global', function($query, $value){
            $query->where(function($query) use ($value){
                Collection::wrap($value)->each(function($value) use ($query){
                    $query->orWhere('name', 'LIKE', "%{$value}%")
                            ->orWhere('slug', 'LIKE', "%{$value}%");
                });
            });
        });
        $posts = QueryBuilder::for(Post::class)
                ->defaultSort('title')
                ->allowedSorts(['title', 'slug'])
                ->allowedFilters(['title', 'slug', 'category_id', $globarSearch]);
        $categories = Category::pluck('name', 'id')->toArray();
        $table
        ->column('title', sortable: true, canBeHidden: false)
        ->column('slug', sortable: true)
        ->column('updated_at')
        ->column('action', exportAs: false)
        ->withGlobalSearch(columns: ['title', 'slug'])
        ->selectFilter('category_id', $categories)
        ->bulkAction(
            label: 'Touch Timestamp',
            each: fn (Post $post) => $post->touch(),
            after: fn () => Toast::info('Timestamp Updated!')
        )
        ->bulkAction(
            label: 'Delete Posts',
            each: fn (Post $post) => $post->delete(),
            after: fn () => Toast::info('Posts Deleted!')
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
