<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedRequest;
use App\Http\Traits\UploadFile;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FeedController extends Controller
{
    use UploadFile;

    /**
     * Create a new Feed Image post
     * 
     * @param FeedRequest $request
     * @return JsonResponse
     * 
     */
    public function store(FeedRequest $request)
    {
        try {
            // Check if there is an image
            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'feeds', 'public', auth()->id() . time()  . '_feed_img');
            }
            // Store Feed in database
            $store = Feed::create([
                'user_id' => auth()->id(),
                'caption' => $request->caption,
                'image' => $path
            ]);

            if (!$store) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create feed',
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'success' => true,
                'message' => 'Feed created successfully',
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update Feed image post
     * 
     * @param FeedRequest $request
     * @param int $user_id
     * 
     * @return JsonResponse
     * 
     */
    public function update(FeedRequest $request, int $feed_id)
    {
        try {
            $feeds = Feed::find($feed_id);

            // Delete old image
            if ($feeds->image) {
                $this->deleteFile($feeds->image);
            }
            // Check if there is an image and upload new image
            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'feeds', 'public', auth()->id() . time()  . '_feed_img');
            }

            // Update Feed in database
            $update = $feeds->update([
                'caption' => $request->caption,
                'image' => $path
            ]);

            if (!$update) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update feed',
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'success' => true,
                'message' => 'Feed updated successfully',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove Feed image post
     * 
     * @param int $user_id
     * @return JsonResponse
     * 
     */
    public function destroy(int $user_id, string $image_path)
    {
        try {
            $deleteFeed = Feed::where('user_id', $user_id)->where('image', $image_path)->delete();

            if (!$deleteFeed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete feed',
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'success' => true,
                'message' => 'Feed deleted successfully',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
