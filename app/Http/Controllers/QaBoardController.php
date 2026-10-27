<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\CertificationStatus;
use App\Models\Certification;
use App\Models\QuestionThread;

/**
 * 質問掲示板の管理
 * 質問のCRUD、回答のCRUDを担う
 * 
 * redirect先は詳細画面
 */
class QaBoardController extends Controller
{
    /**
     * 一覧表示画面
     * 資格別、解決・未解決で検索
     */
    public function index(Request $request){ 
        //$this->authorize('viewAny', QaThread::class);

        $user = auth()->user();

        $certifications = Certification::where('status', CertificationStatus::Published)
            ->get();

        $publishedStatus = CertificationStatus::cases();

        /*if ($user->role === UserRole::Coach) {
            $query->whereIn(
                'certification_id', $user->coachingCertificationIds()
            );
        }

        if ($user->role === UserRole::Admin) {
            $certifications = Certification::all();
        } else {
            $certifications = Certification::where(
                'status',
                CertificationStatus::Published
            )->get();
        }
        */

        // フィルター

        $query = QuestionThread::query();

        $filters = $request->input('filters', [
            'status' => $request->input('status', ''),
            'certification_id' => $request->input('certification_id'),
            'keyword' => $request->input('keyword'),
        ]);

        if ($filters['status'] == 'unresolved') {
            $query->where('status', QaThreadStatus::Open);
        } elseif ($filters['status'] == 'resolved') {
            $query->where('status', QaThreadStatus::Resolved);
        }

        if (! empty($filters['certification_id'])) {
            $query->where('certification_id', $filters['certification_id']);
        }

        if (! empty($filters['keyword'])) {
            $query->where('body', 'like', '%'.$filters['keyword'].'%');
        }

        $threads = $query
            ->with('certification')
            ->with('user')
            ->withCount('answers')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('qa-thread.index',
            compact('filters', 'certifications', 'indexRoute', 'publishedStatus', 'threads'));

    }

    /**
     * 詳細表示画面表示
     */
    public function show(){
        return view('qa-thread.show');
    }

    /**
     * 新規作成画面表示
     */
    public function create(){
        return view('qa-thread.create');
    }

    /**
     * 質問を保存する
     * DBに保存するロジックはstoreActionに分離
     */
    public function store(){
        return redirect()->route('qa-thread.show');
    }

    /**
     * 編集画面表示
     */
    public function edit(){
        return view('qa-thread.edit');
    }

    /**
     * 質問を更新する
     * DBに保存するロジックはstoreActionに分離
     */
    public function putch(){
        return redirect()->route('qa-thread.show');
    }

    /**
     * 質問を削除する
     */
    public function delete(){
        return redirect()->route('qa-thread.show');
    }
}
