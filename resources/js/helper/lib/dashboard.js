const DashboardConfig = {
	body: "app-body-area",
	loader: "top",
};

const Dashboard = {
	load: (url, callback) => {
		Helper.div(DashboardConfig.body).load({
            url: url == null ? Helper.url.get(),
            loader: DashboardConfig.loader,
            changeUrl: true,
            scrapeArea: DashboardConfig.body
        }, function(response) {
            if ($.isFunction(callback)) callback(response);
        });
	}
};