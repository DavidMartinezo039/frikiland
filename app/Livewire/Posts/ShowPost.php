<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ShowPost extends Component
{
    use WithFileUploads;

    public Post $post;

    /** REPLY ROOT */
    public string $content = '';
    public array $media = [];
    public array $newMedia = [];

    /** FEED ROOT */
    public Collection $replies;
    public int $perPage = 5;
    public int $loaded = 0;
    public bool $hasMore = true;

    /** REPLIES HIJAS */
    public int $repliesStep = 5;
    public array $visibleReplies = [];

    /** FORMULARIO REPLY HIJA */
    public ?int $replyingTo = null;
    public string $replyContent = '';
    public array $replyMedia = [];
    public array $newReplyMedia = [];

    protected $rules = [
        'content' => 'required|min:1|max:280',
        'media.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,webm|max:20480',
    ];

    public function mount(Post $post)
    {
        $this->post = $post->load('user');
        $this->replies = collect();
        $this->loadReplies();
    }

    /* MEDIA ROOT */
    public function updatedNewMedia()
    {
        foreach ($this->newMedia as $file) {
            $this->media[] = $file;
        }
        $this->newMedia = [];
    }

    public function removeTempMedia($index)
    {
        unset($this->media[$index]);
        $this->media = array_values($this->media);
    }

    /* MEDIA HIJA */
    public function updatedNewReplyMedia()
    {
        foreach ($this->newReplyMedia as $file) {
            $this->replyMedia[] = $file;
        }
        $this->newReplyMedia = [];
    }

    public function removeReplyMedia($index)
    {
        unset($this->replyMedia[$index]);
        $this->replyMedia = array_values($this->replyMedia);
    }

    /* ADD REPLY ROOT */
    public function addReply()
    {
        $this->validate();

        $mediaPaths = collect($this->media)
            ->map(fn($f) => $f->store('replies', 'public'))
            ->toArray();

        $this->post->replies()->create([
            'user_id' => Auth::id(),
            'content' => $this->content,
            'media'   => $mediaPaths,
        ]);

        $this->reset(['content', 'media', 'newMedia']);
        $this->refreshReplies();
    }

    /* LOAD ROOT REPLIES */
    public function loadReplies()
    {
        if (!$this->hasMore) return;

        $newReplies = Post::where('parent_id', $this->post->id)
            ->with('user')
            ->latest()
            ->skip($this->loaded)
            ->take($this->perPage)
            ->get();

        if ($newReplies->isEmpty()) {
            $this->hasMore = false;
            return;
        }

        $this->replies = $this->replies->merge($newReplies);
        $this->loaded += $newReplies->count();
    }


    public function refreshReplies()
    {
        $this->replies = collect();
        $this->loaded = 0;
        $this->hasMore = true;
        $this->loadReplies();
    }

    /* REPLIES HIJAS */
    public function getVisibleReplies(Post $reply)
    {
        $limit = $this->visibleReplies[$reply->id] ?? 0;
        if ($limit === 0) return collect();

        return $reply->replies()->with('user')->latest()->take($limit)->get();
    }

    public function showMoreReplies(int $id)
    {
        $this->visibleReplies[$id] = ($this->visibleReplies[$id] ?? 0) + $this->repliesStep;
    }

    public function showLessReplies(int $id)
    {
        unset($this->visibleReplies[$id]);
    }

    /* FORMULARIO HIJO */
    public function startReply(int $id)
    {
        $this->replyingTo = $id;
        $this->reset(['replyContent', 'replyMedia', 'newReplyMedia']);
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->reset(['replyContent', 'replyMedia', 'newReplyMedia']);
    }

    public function addChildReply()
    {
        $this->validate([
            'replyContent' => 'required|min:1|max:280',
            'replyMedia.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,webm|max:20480',
        ]);

        $mediaPaths = collect($this->replyMedia)
            ->map(fn($f) => $f->store('replies', 'public'))
            ->toArray();

        Post::create([
            'user_id'   => Auth::id(),
            'content'   => $this->replyContent,
            'parent_id' => $this->replyingTo,
            'media'     => $mediaPaths,
        ]);

        $this->showMoreReplies($this->replyingTo);
        $this->cancelReply();
    }

    public function render()
    {
        return view('livewire.posts.show-post');
    }
}
