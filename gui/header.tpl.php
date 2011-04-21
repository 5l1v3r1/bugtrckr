<!doctype html>
<html>
	<head>
        <meta charset="UTF-8" />
		<link href="/{@BASE}gui/style.css" rel="stylesheet" type="text/css" />
		<title>{@pageTitle} - {@title}</title>
	</head>

	<body>
        <div id="head">
            <h1>{@title}</h1>
        </div>
        <div id="menu">
            <ul>
                <li><a href="/{@BASE}">{@lng.home}</a></li>
                <F3:check if="{@SESSION.project}">
                    <F3:true>
                        <li><a href="/{@BASE}tickets">{@lng.tickets}</a></li>
                        <li><a href="/{@BASE}roadmap">{@lng.roadmap}</a></li>
                        <li><a href="/{@BASE}timeline">{@lng.timeline}</a></li>
                    </F3:true>
                </F3:check>
                <F3:check if="{@SESSION.userId}">
                    <F3:false>
                        <li><a href="/{@BASE}user/new">{@lng.registration}</a></li>
                    </F3:false>
                </F3:check>

				<li>
					<form method="POST" action="/{@BASE}project/select">
						<select name="project" size="1" onclick="submit()">
							<F3:repeat group="{@projects}" value="{@project}">
								<F3:check if="{@project.id == @SESSION.project}">
									<F3:true>
										<option value="{@project.hash}"
												selected="selected">
											{@project.name}
										</option>
									</F3:true>
									<F3:false>
										<option value="{@project.hash}">
											{@project.name}
										</option>
									</F3:false>
								</F3:check>
							</F3:repeat>
						</select>
					</form>
				</li>
                <F3:check if="{@SESSION.userId}">
                    <F3:true>
                        <li class="alignright">Eingeloggt als <a href="/{@BASE}user/{@SESSION.userName}" class="normLink"><strong class="normalText">{@SESSION.userName}</strong></a> [<a href="/{@BASE}user/logout" class="normalText normLink">{@lng.logout}</a>]</li>
                    </F3:true>
                    <F3:false>
                        <li class="alignright"><a href="/{@BASE}user/login" onclick="document.getElementById('login').style.display = 'block'; return false" class="normLink">{@lng.login}</a></li>
                    </F3:false>
                </F3:check>
			</ul>
            <br class="clearfix" />

            <div id="login">
                <h3 class="floatleft">{@lng.login}</h3>
                <a class="closeButton" href="#" onclick="document.getElementById('login').style.display = 'none'">
                    X
                </a>

                <form action="/{@BASE}user/login" method="post">
                    <div class="formRow">
                        <div class="formLabel">{@lng.email}: </div>
                        <div class="formValue"><input type="text" name="email" /></div>
                    </div>
                    <div class="formRow">
                        <div class="formLabel">{@lng.password}: </div>
                        <div class="formValue"><input type="password" name="password" /></div>
                    </div>
                    <div class="formRow">
                        <div class="formLabel">&nbsp;</div>
                        <div class="formValue"><a href="/{@BASE}user/new">{@lng.noaccount}</a></div>
                    </div>
                    <div class="formRow">
                        <div class="formLabel">&nbsp;</div>
                        <div class="formValue"><input type="submit" value="{@lng.login}" /></div>
                    </div>
                </form>
                <br class="clearfix" />
            </div>
        </div>
	

        <div id="content">
			<div id="innerContentLOL">

