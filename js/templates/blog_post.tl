{#.:.}
    <div class="panel panel-primary blogPost" data-postID="{id}">
        <div class="panel-heading">{title}</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-1" style="border-right: 1px solid #428BCA; padding-left: 5px;">
                    <img src="upload/{avPath}" class="img-responsive"/>

                            <span class="postMetaText">
                                <a href="#">{username}</a>
                            </span>

                    <br/>

                    <span class="postMetaText">{addedAt}</span>

                    <br/>

                    <span class="postMetaText"><a class="btnToggleComments" href="#">Comments</a></span>
                </div>

                <div class="col-xs-11">
                    <div class="postText">
                        {content}
                    </div>
                </div>
            </div>

            <div class="row postComments" style="border-top: 1px solid #428BCA; margin-top: 10px; display: none;">
            </div>

            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-11">
                    <input type="text" class="form-control input-sm txtComment" placeholder="Post a comment" style="width: 100%;" />
                </div>
            </div>

        </div>
    </div>
{/.}