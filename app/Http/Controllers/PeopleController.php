<?php

namespace App\Http\Controllers;

use App\Person;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /*****************/
	/**** AJAX *******/
	/*****************/

	/**
     * Upload image of a user.
     *
     * @param  Request
     * @param  $id
     * @return Response
     */
	public function ajaxUploadImage(Request $request, $id)
	{
		// Find the person by id
		$person = Person::find($id);

		if (!$person) // Return error if person is not found
			return array('status' => 'ERROR', 'error' => 'Person not found.');

		// Process the uploaded image
		if ($request->hasFile('image')) {

			// Set up directory where to save the image
		    $ds = DIRECTORY_SEPARATOR;
			$storeFolder = $ds . 'img' . $ds . 'avatars' . $ds . 'persons' . $ds . $id;

			if ($request->file('image')->isValid()) {
				if(!is_dir(public_path() . $storeFolder)) { // If directory does not exist, create it with write permissions
			      	mkdir(public_path() . $storeFolder, 0755, TRUE);
			    }

			    $file = $request->file('image');

			    // Set a unique fileneme for the image
			    $filename = uniqid() . '.' . $file->guessClientExtension();

			    // Save the image to the designated folder
		    	if ($targetFile = $file->move(public_path() . $storeFolder, $filename)) {
		    		$pseudoFile = str_replace(public_path() . $storeFolder, $storeFolder, $targetFile);

		    		// Save image path
		    		$person->image = $pseudoFile;
		    		$person->save();	    

					return array('status' => 'OK', 'result' => $person);
			    }
			    else {
			    	return array('status' => 'ERROR', 'error' => 'Error encountered while uploading photo.');
		    	}
		    }
		    else {
		    	return array('status' => 'ERROR', 'error' => 'Error encountered while uploading photo.');
	    	}
		}
		else {
			return array('status' => 'ERROR', 'error' => 'Error encountered while uploading photo.');
		}
	}
}
