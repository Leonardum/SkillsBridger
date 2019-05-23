<h1>What type of job would you like to publish:</h1>

<div>
	<?php
		if ($companyId == 1) {
			echo "<a href=./index.php?action=studyRelevantJob1&companyId=$companyId>";
			echo "<div class='jobType'>";
			echo "<div class='jobTypeHelp'>";
			echo "<p>Studyrelevant side job</p>";
			echo "</div>";
			echo "</div>";
			echo "</a>";
		}
	?>
	
	<a href="./index.php?action=fixedTerm&companyId=<?php echo $companyId; ?>">
		<div class="jobType">
			<div class="jobTypeHelp">
				<p>Fixed term contract</p>
			</div>
		</div>
	</a>
	<a href="./index.php?action=indefiniteContract&companyId=<?php echo $companyId; ?>">
		<div class="jobType">
			<div class="jobTypeHelp">
				<p>Indefinite duration contract</p>
			</div>
		</div>
	</a>
	<a href="./index.php?action=interim&companyId=<?php echo $companyId; ?>">
		<div class="jobType">
			<div class="jobTypeHelp">
				<p>Interim job</p>
			</div>
		</div>
	</a>
	<a href="./index.php?action=studentJob&companyId=<?php echo $companyId; ?>">
		<div class="jobType">
			<div class="jobTypeHelp">
				<p>Student job</p>
			</div>
		</div>
	</a>
	<a href="./index.php?action=volunteerWork&companyId=<?php echo $companyId; ?>">
		<div class="jobType">
			<div class="jobTypeHelp">
				<p>Volunteer work</p>
			</div>
		</div>
	</a>
	
	<!--
	-->
</div>