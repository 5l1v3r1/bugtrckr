<h2>{{@lng.login}}</h2>

<check if="{{isset(@SESSION.user.hash)}}">
    <true>
        <p>{{@lng.alreadyLoggedIn}}</p>
    </true>
    <false>
        <form action="user/login" method="post">
            <div class="formRow">
                <div class="formLabel">{{@lng.email}}: </div>
                <div class="formValue"><input type="text" name="email" /></div>
            </div>
            <div class="formRow">
                <div class="formLabel">{{@lng.password}}: </div>
                <div class="formValue"><input type="password" name="password" /></div>
            </div>
            <div class="formRow">
                <div class="formLabel"> </div>
                <div class="formValue"><input type="submit" clas="btn" value="{{@lng.login}}" /></div>
            </div>
        </form>
    </false>
</check>
