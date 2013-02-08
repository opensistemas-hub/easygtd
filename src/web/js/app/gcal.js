/*
 * FullCalendar v1.4.6 Google Calendar Extension
 *
 * Copyright (c) 2009 Adam Shaw
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Date: Mon May 31 10:18:29 2010 -0700
 *
 */

(function(jq) {

	jq.fullCalendar.gcalFeed = function(feedUrl, options) {
		
		feedUrl = feedUrl.replace(/\/basicjq/, '/full');
		options = options || {};
		
		return function(start, end, callback) {
			var params = {
				'start-min': jq.fullCalendar.formatDate(start, 'u'),
				'start-max': jq.fullCalendar.formatDate(end, 'u'),
				'singleevents': true,
				'max-results': 9999
			};
			var ctz = options.currentTimezone;
			if (ctz) {
				params.ctz = ctz = ctz.replace(' ', '_');
			}
			jq.getJSON(feedUrl + "?alt=json-in-script&callback=?", params, function(data) {
				var events = [];
				if (data.feed.entry) {
					jq.each(data.feed.entry, function(i, entry) {
						var startStr = entry['gdjqwhen'][0]['startTime'],
							start = jq.fullCalendar.parseISO8601(startStr, true),
							end = jq.fullCalendar.parseISO8601(entry['gdjqwhen'][0]['endTime'], true),
							allDay = startStr.indexOf('T') == -1,
							url;
						jq.each(entry.link, function() {
							if (this.type == 'text/html') {
								url = this.href;
								if (ctz) {
									url += (url.indexOf('?') == -1 ? '?' : '&') + 'ctz=' + ctz;
								}
							}
						});
						if (allDay) {
							jq.fullCalendar.addDays(end, -1); // make inclusive
						}
						events.push({
							id: entry['gCaljquid']['value'],
							title: entry['title']['jqt'],
							url: url,
							start: start,
							end: end,
							allDay: allDay,
							location: entry['gdjqwhere'][0]['valueString'],
							description: entry['content']['jqt'],
							className: options.className,
							editable: options.editable || false
						});
					});
				}
				callback(events);
			});
		}
		
	}

})(jQuery);
