<h1>{@ticket.title}</h1>

<div class="ticket">
	<table class="ticket">
		<tr>
			<th>{@lng.STATUS}</th>
			<td>{@ticket.state}</td>
			<th>{@lng.created}</th>
			<td>{@ticket.created}</td>
		</tr>

		<tr>
			<th>{@lng.priority}</th>
			<td>{@ticket.priority}</td>
			<th></th>
			<td></td>
		</tr>

		<tr>
			<th>{@lng.owner}</th>
			<td>{@ticket.owner}</td>
			<th></th>
			<td></td>
		</tr>

		<tr>
			<th>{@lng.category}</th>
			<td>{@ticket.category}</td>
			<th></th>
			<td></td>
		</tr>

		<tr>
			<th>{@lng.milestone}</th>
			<td>{@milestone.name}</td>
			<th></th>
			<td></td>
		</tr>
	</table>

	<hr noshade="noshade" />

	<h2>{@lng.description}</h2>

	<p>
		{@ticket.description}
	</p>
</div>


