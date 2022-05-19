<div class="container">
	<div class="row">
		<div class="col-12">
			<h1 class="display-3 text-center text-white pt-5 pb-3 mt-5 mb-3">
                New Note
            </h1>
			<form class="form col-4 mx-auto" method="post"
                  action="note@create">

				<?php
					require(ROOT . 'App/Views/Shared/Components/note_inputs.php');
				?>
				
				<div class="row mb-3">
					<div class="col-6 d-grid">
						<button class="btn btn-danger" type="reset">
							Reset
						</button>
					</div>
					<div class="col-6 d-grid">
						<button class="btn btn-primary" type="submit"
								name="submit">
							Create
						</button>
					</div>
				</div>
			</form>
			<div class="mt-3">
				<p class="text-white text-center">
					<?=$msg ?? ''?>
				</p>
			</div>
		</div>
	</div>
</div>
